@extends('adminpanel')
@section('admin')
@if(Auth::check() && Auth::user()->role=='adminManager' || Auth::user()->role=='admin' || Auth::user()->role=='manager' || Auth::user()->role=='interviewer')
<div class="layout-px-spacing">
    <div class="middle-content container-xxl p-0">
        <!--  BEGIN BREADCRUMBS  -->
        <div class="secondary-nav">
            <div class="breadcrumbs-container" data-page-heading="Analytics">
                <header class="header navbar navbar-expand-sm">
                    <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                    </a>
                    <div class="d-flex breadcrumb-content">
                        <div class="page-header">
                            <div class="page-title">
                            </div>
                            <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Main</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </header>
            </div>
        </div>
        <!--  END BREADCRUMBS  -->

        <div class="row layout-top-spacing">
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h5 class="">Applications</h5>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="renvenue" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                </a>
                                <div class="dropdown-menu left" aria-labelledby="renvenue" style="will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0);">Weekly</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Monthly</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Yearly</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content">
                        <div id="revenueMonthly"></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-two">
                    <div class="widget-heading">
                        <h5 class="">Application Processing</h5>
                    </div>
                    <div class="widget-content">
                        <div id="chart-2" class=""></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget-four">
                    <div class="widget-heading">
                        <h5 class="">Last 30 Days Application</h5>
                    </div>
                    <div class="widget-content">
                        <div class="vistorsBrowser">
                            <div class="browser-list">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chrome"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="4"></circle><line x1="21.17" y1="8" x2="12" y2="8"></line><line x1="3.95" y1="6.06" x2="8.54" y2="14"></line><line x1="10.88" y1="21.94" x2="15.46" y2="14"></line></svg>
                                </div>
                                <div class="w-browser-details">
                                    <div class="w-browser-info">
                                        <h6>Total Application</h6>
                                        <p class="browser-count">{{ $application_count }}</p>
                                    </div>
                                    <div class="w-browser-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: {{ $application_count }}%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="browser-list">
                                <div class="w-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                </div>
                                <div class="w-browser-details">

                                    <div class="w-browser-info">
                                        <h6>Enrolled Students</h6>
                                        <p class="browser-count">{{ $application_enrolled_count }}</p>
                                    </div>

                                    <div class="w-browser-stats">
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-warning" role="progressbar" style="width: {{ $application_enrolled_count }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row widget-statistic">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <div class="widget widget-one_hybrid widget-followers">
                            <div class="widget-heading">
                                <div class="w-title">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    </div>
                                    <div class="">
                                        <p class="w-value">{{ $total_application }}</p>
                                        <h5 class="">Total Application</h5>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <div class="widget widget-one_hybrid widget-referral">
                            <div class="widget-heading">
                                <div class="w-title">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                                    </div>
                                    <div class="">
                                        <p class="w-value">{{ $total_enrolled }}</p>
                                        <h5 class="">Total Enrolled</h5>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12 layout-spacing">
                        <div class="widget widget-one_hybrid widget-engagement">
                            <div class="widget-heading">
                                <div class="w-title">
                                    <div class="w-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                    </div>
                                    <div class="">
                                        <p class="w-value">{{ $total_ongoing }}</p>
                                        <h5 class="">Total Ongoing Application</h5>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-two">

                    <div class="widget-heading">
                        <h5 class="">Recent Application</h5>
                    </div>

                    <div class="widget-content">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><div class="th-content">Applicant</div></th>
                                        <th><div class="th-content">Email</div></th>
                                        <th><div class="th-content">Phone</div></th>
                                        <th><div class="th-content th-heading">Campus</div></th>
                                        <th><div class="th-content">Status</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($applications_list) > 0)
                                    @foreach($applications_list as $applicationRow)
                                    <tr>
                                        <td><div class="td-content customer-name"><span>{{ $applicationRow->name }}</span></div></td>
                                        <td><div class="td-content product-brand text-primary">{{ $applicationRow->email }}</div></td>
                                        <td><div class="td-content product-invoice">{{ $applicationRow->phone }}</div></td>
                                        <td><div class="td-content pricing"><span class="">{{ $applicationRow->campus->campus_name }}</span></div></td>
                                        <td><div class="td-content">
                                            @if($applicationRow->status==1)
                                            <span class="badge badge-danger">New</span>
                                            @elseif($applicationRow->status==2)
                                            <span class="badge badge-primary">Elt or Interview Passed</span>
                                            @elseif($applicationRow->status==3)
                                            <span class="badge badge-primary">Conditional Offer</span>
                                            @elseif($applicationRow->status==4)
                                            <span class="badge badge-secondary">Unconditional Offer</span>
                                            @elseif($applicationRow->status==5)
                                            <span class="badge badge-success">Enrolled</span>
                                            @elseif($applicationRow->status==5)
                                            <span class="badge badge-danger">Rejected</span>
                                            @else
                                            @endif

                                        </div></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-activity-four">

                    <div class="widget-heading">
                        <h5 class="">Recent Activities</h5>
                    </div>

                    <div class="widget-content">

                        <div class="mt-container-ra mx-auto">
                            <div class="timeline-line">
                                @if(count($activities) > 0)
                                @foreach($activities as $activity)
                                <div class="item-timeline timeline-primary">
                                    <div class="t-dot" data-original-title="" title="">
                                    </div>
                                    <div class="t-text">
                                        <span>{!! $activity->description !!}</span>
                                        <p class="t-time">{{ App\Models\Notification\Notification::timeLeft($activity->create_date) }}</p>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="tm-action-btn">
                            <a href="{{ URL::to('show-all-activity') }}" class="btn"><span>View All</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<script>
    window.addEventListener("load", function(){

try {

  getcorkThemeObject = localStorage.getItem("theme");
  getParseObject = JSON.parse(getcorkThemeObject)
  ParsedObject = getParseObject;

  if (ParsedObject.settings.layout.darkMode) {

    var Theme = 'dark';

    Apex.tooltip = {
        theme: Theme
    }

    /**
        ==============================
        |    @Options Charts Script   |
        ==============================
    */

    /*
        =============================
            Daily Sales | Options
        =============================
    */
    var d_2options1 = {
      chart: {
          height: 160,
          type: 'bar',
          stacked: true,
          stackType: '100%',
          toolbar: {
              show: false,
          }
      },
      dataLabels: {
          enabled: false,
      },
      stroke: {
          show: true,
          width: [3, 4],
          curve: "smooth",
      },
      colors: ['#e2a03f', '#e0e6ed'],
      series: [{
          name: 'Sales',
          data: [44, 55, 41, 67, 22, 43, 21]
      },{
          name: 'Last Week',
          data: [13, 23, 20, 8, 13, 27, 33]
      }],
      xaxis: {
          labels: {
              show: false,
          },
          categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
          crosshairs: {
          show: false
          }
      },
      yaxis: {
          show: false
      },
      fill: {
          opacity: 1
      },
      plotOptions: {
          bar: {
              horizontal: false,
              columnWidth: '25%',
              borderRadius: 8,
          }
      },
      legend: {
          show: false,
      },
      grid: {
          show: false,
          xaxis: {
              lines: {
                  show: false
              }
          },
          padding: {
          top: -20,
          right: 0,
          bottom: -40,
          left: 0
          },
      },
      responsive: [
          {
              breakpoint: 575,
              options: {
                  plotOptions: {
                      bar: {
                          borderRadius: 5,
                          columnWidth: '35%'
                      }
                  },
              }
          },
      ],
    }

    /*
        =============================
            Total Orders | Options
        =============================
    */
    var d_2options2 = {
      chart: {
        id: 'sparkline1',
        group: 'sparklines',
        type: 'area',
        height: 290,
        sparkline: {
          enabled: true
        },
      },
      stroke: {
          curve: 'smooth',
          width: 2
      },
      fill: {
        type:"gradient",
        gradient: {
            type: "vertical",
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .30,
            opacityTo: .05,
            stops: [100, 100]
        }
      },
      series: [{
        name: 'Sales',
        data: [28, 40, 36, 52, 38, 60, 38, 52, 36, 40]
      }],
      labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
      yaxis: {
        min: 0
      },
      grid: {
        padding: {
          top: 125,
          right: 0,
          bottom: 0,
          left: 0
        },
      },
      tooltip: {
        x: {
          show: false,
        },
        theme: Theme
      },
      colors: ['#00ab55']
    }

    /*
        =================================
            Revenue Monthly | Options
        =================================
    */
    var options1 = {
      chart: {
        fontFamily: 'Nunito, sans-serif',
        height: 365,
        type: 'area',
        zoom: {
            enabled: false
        },
        dropShadow: {
          enabled: true,
          opacity: 0.2,
          blur: 10,
          left: -7,
          top: 22
        },
        toolbar: {
          show: false
        },
      },
      colors: ['#e7515a', '#2196f3'],
      dataLabels: {
          enabled: false
      },
      markers: {
        discrete: [{
        seriesIndex: 0,
        dataPointIndex: 7,
        fillColor: '#000',
        strokeColor: '#000',
        size: 5
      }, {
        seriesIndex: 2,
        dataPointIndex: 11,
        fillColor: '#000',
        strokeColor: '#000',
        size: 4
      }]
      },
      subtitle: {
        text: <?php echo $total_application; ?>,
        align: 'left',
        margin: 0,
        offsetX: 150,
        offsetY: 20,
        floating: false,
        style: {
          fontSize: '18px',
          color:  '#00ab55'
        }
      },
      title: {
        text: 'Total Application',
        align: 'left',
        margin: 0,
        offsetX: -10,
        offsetY: 20,
        floating: false,
        style: {
          fontSize: '18px',
          color:  '#bfc9d4'
        },
      },
      stroke: {
          show: true,
          curve: 'smooth',
          width: 2,
          lineCap: 'square'
      },
      series: [{
          name: 'Direct Applications',
          data: [<?php echo $direct_atring; ?>]
      }, {
          name: 'Agent Applications',
          data: [<?php echo $agent_atring; ?>]
      }],
      labels: [<?php echo $month_string; ?>],
      xaxis: {
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        crosshairs: {
          show: true
        },
        labels: {
          offsetX: 0,
          offsetY: 5,
          style: {
              fontSize: '12px',
              fontFamily: 'Nunito, sans-serif',
              cssClass: 'apexcharts-xaxis-title',
          },
        }
      },
      yaxis: {
        labels: {
          formatter: function(value, index) {
            return (value / 100) + 'k'
          },
          offsetX: -15,
          offsetY: 0,
          style: {
              fontSize: '12px',
              fontFamily: 'Nunito, sans-serif',
              cssClass: 'apexcharts-yaxis-title',
          },
        }
      },
      grid: {
        borderColor: '#191e3a',
        strokeDashArray: 5,
        xaxis: {
            lines: {
                show: true
            }
        },
        yaxis: {
            lines: {
                show: false,
            }
        },
        padding: {
          top: -50,
          right: 0,
          bottom: 0,
          left: 5
        },
      },
      legend: {
        position: 'top',
        horizontalAlign: 'right',
        offsetY: -50,
        fontSize: '16px',
        fontFamily: 'Quicksand, sans-serif',
        markers: {
          width: 10,
          height: 10,
          strokeWidth: 0,
          strokeColor: '#fff',
          fillColors: undefined,
          radius: 12,
          onClick: undefined,
          offsetX: -5,
          offsetY: 0
        },
        itemMargin: {
          horizontal: 10,
          vertical: 20
        }

      },
      tooltip: {
        theme: Theme,
        marker: {
          show: true,
        },
        x: {
          show: false,
        }
      },
      fill: {
          type:"gradient",
          gradient: {
              type: "vertical",
              shadeIntensity: 1,
              inverseColors: !1,
              opacityFrom: .19,
              opacityTo: .05,
              stops: [100, 100]
          }
      },
      responsive: [{
        breakpoint: 575,
        options: {
          legend: {
              offsetY: -50,
          },
        },
      }]
    }

    /*
        ==================================
            Sales By Category | Options
        ==================================
    */
    var options = {
        chart: {
            type: 'donut',
            width: 370,
            height: 430
        },
        colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
        dataLabels: {
          enabled: false
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
              width: 10,
              height: 10,
              offsetX: -5,
              offsetY: 0
            },
            itemMargin: {
              horizontal: 10,
              vertical: 30
            }
        },
        plotOptions: {
          pie: {
            donut: {
              size: '75%',
              background: 'transparent',
              labels: {
                show: true,
                name: {
                  show: true,
                  fontSize: '29px',
                  fontFamily: 'Nunito, sans-serif',
                  color: undefined,
                  offsetY: -10
                },
                value: {
                  show: true,
                  fontSize: '26px',
                  fontFamily: 'Nunito, sans-serif',
                  color: '#bfc9d4',
                  offsetY: 16,
                  formatter: function (val) {
                    return val
                  }
                },
                total: {
                  show: true,
                  showAlways: true,
                  label: 'Total',
                  color: '#888ea8',
                  fontSize: '30px',
                  formatter: function (w) {
                    return w.globals.seriesTotals.reduce( function(a, b) {
                      return a + b
                    }, 0)
                  }
                }
              }
            }
          }
        },
        stroke: {
          show: true,
          width: 15,
          colors: '#0e1726'
        },
        series: [<?php echo $processing_data; ?>],
        labels: ['Enrolled', 'Ongoing', 'Interview Passed'],

        responsive: [
          {
            breakpoint: 1440, options: {
              chart: {
                width: 325
              },
            }
          },
          {
            breakpoint: 1199, options: {
              chart: {
                width: 380
              },
            }
          },
          {
            breakpoint: 575, options: {
              chart: {
                width: 320
              },
            }
          },
        ],
    }

  } else {

    var Theme = 'dark';

    Apex.tooltip = {
        theme: Theme
    }

    /**
        ==============================
        |    @Options Charts Script   |
        ==============================
    */

    /*
        =============================
            Daily Sales | Options
        =============================
    */
    var d_2options1 = {
      chart: {
          height: 160,
          type: 'bar',
          stacked: true,
          stackType: '100%',
          toolbar: {
              show: false,
          }
      },
      dataLabels: {
          enabled: false,
      },
      stroke: {
          show: true,
          width: [3, 4],
          curve: "smooth",
      },
      colors: ['#e2a03f', '#e0e6ed'],
      series: [{
          name: 'Sales',
          data: [44, 55, 41, 67, 22, 43, 21]
      },{
          name: 'Last Week',
          data: [13, 23, 20, 8, 13, 27, 33]
      }],
      xaxis: {
          labels: {
              show: false,
          },
          categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'],
          crosshairs: {
          show: false
          }
      },
      yaxis: {
          show: false
      },
      fill: {
          opacity: 1
      },
      plotOptions: {
          bar: {
              horizontal: false,
              columnWidth: '25%',
              borderRadius: 8,
          }
      },
      legend: {
          show: false,
      },
      grid: {
          show: false,
          xaxis: {
              lines: {
                  show: false
              }
          },
          padding: {
          top: -20,
          right: 0,
          bottom: -40,
          left: 0
          },
      },
      responsive: [
          {
              breakpoint: 575,
              options: {
                  plotOptions: {
                      bar: {
                          borderRadius: 5,
                          columnWidth: '35%'
                      }
                  },
              }
          },
      ],
    }

    /*
        =============================
            Total Orders | Options
        =============================
    */
    var d_2options2 = {
      chart: {
        id: 'sparkline1',
        group: 'sparklines',
        type: 'area',
        height: 290,
        sparkline: {
          enabled: true
        },
      },
      stroke: {
          curve: 'smooth',
          width: 2
      },
      fill: {
        opacity: 1,
        // type:"gradient",
        // gradient: {
        //     type: "vertical",
        //     shadeIntensity: 1,
        //     inverseColors: !1,
        //     opacityFrom: .30,
        //     opacityTo: .05,
        //     stops: [100, 100]
        // }
      },
      series: [{
        name: 'Sales',
        data: [28, 40, 36, 52, 38, 60, 38, 52, 36, 40]
      }],
      labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
      yaxis: {
        min: 0
      },
      grid: {
        padding: {
          top: 125,
          right: 0,
          bottom: 0,
          left: 0
        },
      },
      tooltip: {
        x: {
          show: false,
        },
        theme: Theme
      },
      colors: ['#00ab55']
    }

    /*
        =================================
            Revenue Monthly | Options
        =================================
    */
    var options1 = {
      chart: {
        fontFamily: 'Nunito, sans-serif',
        height: 365,
        type: 'area',
        zoom: {
            enabled: false
        },
        dropShadow: {
          enabled: true,
          opacity: 0.2,
          blur: 10,
          left: -7,
          top: 22
        },
        toolbar: {
          show: false
        },
      },
      colors: ['#1b55e2', '#e7515a'],
      dataLabels: {
          enabled: false
      },
      markers: {
        discrete: [{
        seriesIndex: 0,
        dataPointIndex: 7,
        fillColor: '#000',
        strokeColor: '#000',
        size: 5
      }, {
        seriesIndex: 2,
        dataPointIndex: 11,
        fillColor: '#000',
        strokeColor: '#000',
        size: 4
      }]
      },
      subtitle: {
        text: '$10,840',
        align: 'left',
        margin: 0,
        offsetX: 100,
        offsetY: 20,
        floating: false,
        style: {
          fontSize: '18px',
          color:  '#4361ee'
        }
      },
      title: {
        text: 'Total',
        align: 'left',
        margin: 0,
        offsetX: -10,
        offsetY: 20,
        floating: false,
        style: {
          fontSize: '18px',
          color:  '#0e1726'
        },
      },
      stroke: {
          show: true,
          curve: 'smooth',
          width: 2,
          lineCap: 'square'
      },
      series: [{
          name: 'Direct Application',
          data: [<?php echo $direct_atring; ?>]
      }, {
          name: 'Agent Application',
          data: [<?php echo $agent_atring; ?>]
      }],
      labels: [<?php echo $month_string; ?>],
      xaxis: {
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        crosshairs: {
          show: true
        },
        labels: {
          offsetX: 0,
          offsetY: 5,
          style: {
              fontSize: '12px',
              fontFamily: 'Nunito, sans-serif',
              cssClass: 'apexcharts-xaxis-title',
          },
        }
      },
      yaxis: {
        labels: {
          formatter: function(value, index) {
            return (value / 100) + 'K'
          },
          offsetX: -15,
          offsetY: 0,
          style: {
              fontSize: '12px',
              fontFamily: 'Nunito, sans-serif',
              cssClass: 'apexcharts-yaxis-title',
          },
        }
      },
      grid: {
        borderColor: '#e0e6ed',
        strokeDashArray: 5,
        xaxis: {
            lines: {
                show: true
            }
        },
        yaxis: {
            lines: {
                show: false,
            }
        },
        padding: {
          top: -50,
          right: 0,
          bottom: 0,
          left: 5
        },
      },
      legend: {
        position: 'top',
        horizontalAlign: 'right',
        offsetY: -50,
        fontSize: '16px',
        fontFamily: 'Quicksand, sans-serif',
        markers: {
          width: 10,
          height: 10,
          strokeWidth: 0,
          strokeColor: '#fff',
          fillColors: undefined,
          radius: 12,
          onClick: undefined,
          offsetX: -5,
          offsetY: 0
        },
        itemMargin: {
          horizontal: 10,
          vertical: 20
        }

      },
      tooltip: {
        theme: Theme,
        marker: {
          show: true,
        },
        x: {
          show: false,
        }
      },
      fill: {
          type:"gradient",
          gradient: {
              type: "vertical",
              shadeIntensity: 1,
              inverseColors: !1,
              opacityFrom: .19,
              opacityTo: .05,
              stops: [100, 100]
          }
      },
      responsive: [{
        breakpoint: 575,
        options: {
          legend: {
              offsetY: -50,
          },
        },
      }]
    }

    /*
        ==================================
            Sales By Category | Options
        ==================================
    */
    var options = {
        chart: {
            type: 'donut',
            width: 370,
            height: 430
        },
        colors: ['#622bd7', '#e2a03f', '#e7515a', '#e2a03f'],
        dataLabels: {
          enabled: false
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
              width: 10,
              height: 10,
              offsetX: -5,
              offsetY: 0
            },
            itemMargin: {
              horizontal: 10,
              vertical: 30
            }
        },
        plotOptions: {
          pie: {
            donut: {
              size: '75%',
              background: 'transparent',
              labels: {
                show: true,
                name: {
                  show: true,
                  fontSize: '29px',
                  fontFamily: 'Nunito, sans-serif',
                  color: undefined,
                  offsetY: -10
                },
                value: {
                  show: true,
                  fontSize: '26px',
                  fontFamily: 'Nunito, sans-serif',
                  color: '#0e1726',
                  offsetY: 16,
                  formatter: function (val) {
                    return val
                  }
                },
                total: {
                  show: true,
                  showAlways: true,
                  label: 'Total',
                  color: '#888ea8',
                  fontSize: '30px',
                  formatter: function (w) {
                    return w.globals.seriesTotals.reduce( function(a, b) {
                      return a + b
                    }, 0)
                  }
                }
              }
            }
          }
        },
        stroke: {
          show: true,
          width: 15,
          colors: '#fff'
        },
        series: [<?php echo $processing_data; ?>],
        labels: ['Enrolled', 'Ongoing', 'Interview Passed'],

        responsive: [
          {
            breakpoint: 1440, options: {
              chart: {
                width: 325
              },
            }
          },
          {
            breakpoint: 1199, options: {
              chart: {
                width: 380
              },
            }
          },
          {
            breakpoint: 575, options: {
              chart: {
                width: 320
              },
            }
          },
        ],
    }
  }


/**
    ==============================
    |    @Render Charts Script    |
    ==============================
*/


/*
    ============================
        Daily Sales | Render
    ============================
*/
var d_2C_1 = new ApexCharts(document.querySelector("#daily-sales"), d_2options1);
d_2C_1.render();

/*
    ============================
        Total Orders | Render
    ============================
*/
var d_2C_2 = new ApexCharts(document.querySelector("#total-orders"), d_2options2);
d_2C_2.render();

/*
    ================================
        Revenue Monthly | Render
    ================================
*/
var chart1 = new ApexCharts(
    document.querySelector("#revenueMonthly"),
    options1
);

chart1.render();

/*
    =================================
        Sales By Category | Render
    =================================
*/
var chart = new ApexCharts(
    document.querySelector("#chart-2"),
    options
);

chart.render();

/*
    =============================================
        Perfect Scrollbar | Recent Activities
    =============================================
*/
const ps = new PerfectScrollbar(document.querySelector('.mt-container-ra'));

// const topSellingProduct = new PerfectScrollbar('.widget-table-three .table-scroll table', {
//   wheelSpeed:.5,
//   swipeEasing:!0,
//   minScrollbarLength:40,
//   maxScrollbarLength:100,
//   suppressScrollY: true

// });





/**
   * =================================================================================================
   * |     @Re_Render | Re render all the necessary JS when clicked to switch/toggle theme           |
   * =================================================================================================
   */

document.querySelector('.theme-toggle').addEventListener('click', function() {

  // console.log(localStorage);

  getcorkThemeObject = localStorage.getItem("theme");
  getParseObject = JSON.parse(getcorkThemeObject)
  ParsedObject = getParseObject;

  if (ParsedObject.settings.layout.darkMode) {

    /*
    =================================
        Revenue Monthly | Options
    =================================
  */

    chart1.updateOptions({
      colors: ['#e7515a', '#2196f3'],
      subtitle: {
        style: {
          color:  '#00ab55'
        }
      },
      title: {
        style: {
          color:  '#bfc9d4'
        }
      },
      grid: {
        borderColor: '#191e3a',
      }
    })


    /*
    ==================================
        Sales By Category | Options
    ==================================
    */

    chart.updateOptions({
      stroke: {
        colors: '#0e1726'
      },
      plotOptions: {
        pie: {
          donut: {
            labels: {
              value: {
                color: '#bfc9d4'
              }
            }
          }
        }
      }
    })


    /*
        =============================
            Total Orders | Options
        =============================
    */

    d_2C_2.updateOptions({
      fill: {
        type:"gradient",
        gradient: {
            type: "vertical",
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .30,
            opacityTo: .05,
            stops: [100, 100]
        }
      }
    })

  } else {

    /*
    =================================
        Revenue Monthly | Options
    =================================
  */

    chart1.updateOptions({
      colors: ['#1b55e2', '#e7515a'],
      subtitle: {
        style: {
          color:  '#4361ee'
        }
      },
      title: {
        style: {
          color:  '#0e1726'
        }
      },
      grid: {
        borderColor: '#e0e6ed',
      }
    })


    /*
    ==================================
        Sales By Category | Options
    ==================================
    */

    chart.updateOptions({
      stroke: {
        colors: '#fff'
      },
      plotOptions: {
        pie: {
          donut: {
            labels: {
              value: {
                color: '#0e1726'
              }
            }
          }
        }
      }
    })


    /*
        =============================
            Total Orders | Options
        =============================
    */

    d_2C_2.updateOptions({
      fill: {
        type:"gradient",
        opacity: 0.9,
        gradient: {
            type: "vertical",
            shadeIntensity: 1,
            inverseColors: !1,
            opacityFrom: .45,
            opacityTo: 0.1,
            stops: [100, 100]
        }
      }
    })


  }

})


} catch(e) {
    console.log(e);
}

})

</script>
@endif
@stop
