/**
*
* Render Suggestion
*
**/

var input = document.querySelector('input[name=course_intake]'),
tagify = new Tagify(input, {
    pattern             : /^.{0,20}$/,  // Validate typed tag(s) by Regex. Here maximum chars length is defined as "20"
    delimiters          : ",| ",        // add new tags when a comma or a space character is entered
    keepInvalidTags     : true,         // do not remove invalid tags (but keep them marked as invalid)
    editTags            : {
        clicks: 2,              // single click to edit a tag
        keepInvalid: false      // if after editing, tag is invalid, auto-revert
    },
    maxTags             : 6,
    blacklist           : ["foo", "bar", "baz"],
    whitelist           : ["React","Angular","TypeScript","Vue","Python","Wordpress","Svelte","PHP","Javascript","HTML","CSS","JSON","XML","Markdown","Go","C++","C#","Java","Docker","Perl","Ruby","Rust","NodeJS","SQL","SQLite","MonogDB","MYSQL","Swift","SCSS","SASS"],
    transformTag        : transformTag,
    backspace           : "edit",
    placeholder         : "Type something",
    dropdown : {
        enabled: 1,            // show suggestion after 1 typed character
        fuzzySearch: false,    // match only suggestions that starts with the typed characters
        position: 'text',      // position suggestions list next to typed text
        caseSensitive: true,   // allow adding duplicate items if their case is different
    },
    templates: {
        dropdownItemNoMatch: function(data) {
            return `<div class='${this.settings.classNames.dropdownItem}' tabindex="0" role="option">
                No suggestion found for: <strong>${data.value}</strong>
            </div>`
        }
    }
})

// generate a random color (in HSL format, which I like to use)
function getRandomColor(){
function rand(min, max) {
    return min + Math.random() * (max - min);
}

var h = rand(1, 360)|0,
    s = rand(40, 70)|0,
    l = rand(65, 72)|0;

return 'hsl(' + h + ',' + s + '%,' + l + '%)';
}

function transformTag( tagData ){
tagData.color = getRandomColor();
tagData.style = "--tag-bg:" + tagData.color;

if( tagData.value.toLowerCase() == 'shit' )
    tagData.value = 's✲✲t'
}

tagify.on('add', function(e){
console.log(e.detail)
})

tagify.on('invalid', function(e){
console.log(e, e.detail);
})

var clickDebounce;

tagify.on('click', function(e){
const {tag:tagElm, data:tagData} = e.detail;

// a delay is needed to distinguish between regular click and double-click.
// this allows enough time for a possible double-click, and noly fires if such
// did not occur.
clearTimeout(clickDebounce);
clickDebounce = setTimeout(() => {
    tagData.color = getRandomColor();
    tagData.style = "--tag-bg:" + tagData.color;
    tagify.replaceTag(tagElm, tagData);
}, 200);
})

tagify.on('dblclick', function(e){
// when souble clicking, do not change the color of the tag
clearTimeout(clickDebounce);
})
