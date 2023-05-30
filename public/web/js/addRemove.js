$(document).ready(function() {
    //e.preventDefault();
    var maxele = 15;
    var count = 1;
    let addbutton = document.getElementById("addAttributeButton1");
    addbutton.addEventListener("click", function() {
    let attributes_boxes = document.getElementById("select-wrapper1");
    let clone = attributes_boxes.firstElementChild.cloneNode(true);
    if(count < maxele){
        count++;
        attributes_boxes.appendChild(clone);
    }

    });
    $("#select-wrapper1").on("click",".remove-attribute-element1", function(e){
        e.preventDefault();

        if(count > 1){
            $(this).parents("#element-wrapper1").remove();
            count--;
        }

    });
});
