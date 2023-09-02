function getvalue() {
    let maximalAccuracyLevel = document.getElementById("acclevel").value;
    location.href+="&acclevel="+maximalAccuracyLevel;
}
var x = location;
x = new URL(x);
function acclevel() {
    accuracy = x.searchParams.get("acclevel");
    if (accuracy !== undefined && accuracy !== null) {
    for (let i = 0; document.getElementsByClassName("accuracy"+i); i++) {
    for (let j in document.getElementsByClassName("accuracy"+i)) {
        if (i > accuracy) {
            document.getElementsByClassName("accuracy"+i)[j].style.display="none";
}
}
}
} else {
 if (location.href.replace("?gnum=","")!=location.href && location.href.replace("acclevel=","")==location.href) {
 document.body.innerHTML+="<hr/>\n<input type='text' style='width: 380px' placeholder='A megjeleníthető szöveghez tartozó maximális pontossági szint*' id='acclevel'/>\n<input type='button' value='Megadás' onclick='getvalue();' /> <p>*Ezek leírása <a href='./?gnum=8532404588323836'>itt</a> található.</p>";
 
}
}
}