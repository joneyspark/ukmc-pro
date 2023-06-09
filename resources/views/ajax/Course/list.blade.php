<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Course Name</th>
            <th scope="col">Campus Name</th>
            <th scope="col">Course Level</th>
            <th scope="col">Duration</th>
            <th scope="col">Intake</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($courses as $course)
        <tr class="{{ (!empty($return_course_id) && $return_course_id==$course->id)?'tr-bg':'' }}">
            <td>{{ (!empty($course->id))?$course->id:'' }}</td>
            <td>{{ (!empty($course->course_name))?$course->course_name:'' }}</td>
            <td>{{ (!empty($course->campus->campus_name))?$course->campus->campus_name:'' }}</td>
            <td>{{ (!empty($course->course_level->title))?$course->course_level->title:'' }}</td>
            <td>{{ (!empty($course->course_duration))?$course->course_duration:'' }}</td>
            <td>{{ (!empty($course->course_intake))?$course->course_intake:'' }}</td>
            <td>
                <div
                    class="switch form-switch-custom switch-inline form-switch-primary form-switch-custom inner-text-toggle">
                    <div class="input-checkbox">
                        <span class="switch-chk-label label-left">On</span>
                        <input {{ ($course->status==1)?'checked':'' }} data-action="{{ URL::to('course-status-chnage') }}" data-id="{{ $course->id }}" class="course-status-chnage switch-input" type="checkbox"
                                                    role="switch" id="form-custom-switch-inner-text">
                        <span class="switch-chk-label label-right">Off</span>
                    </div>
                </div>
            </td>

            <td class="flex space-x-2">
                <a href="{{ URL::to('course-details/'.$course->slug) }}" class="badge badge-pill bg-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-white"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </a>
                <a href="{{ URL::to('course/edit/'.$course->slug) }}" class="badge badge-pill bg-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3 text-white"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </a>
            </td>
        </tr>
        @empty
        <tr>No Data Found</tr>
        @endforelse

    </tbody>
</table>
<div style="text-align: center;" class="pagination-custom_solid">
    {!! $courses->links() !!}
</div>

