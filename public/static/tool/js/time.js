/**
 * Created by 隆航 on 2017/2/24 0024.
 */
var timeNow = new Date();
document.getElementById("firstTimestamp").value = Math.round(timeNow.getTime() / 1000);
var currentTimeActive = 1;
var unixTimer = 0;
function unix2human() {
    var unixTimeValue = new Date(document.unix2beijing.timestamp.value * 1000);
    beijingTimeValue = unixTimeValue.toLocaleString();
    document.unix2beijing.result.value = beijingTimeValue;
}
function human2unix() {
    var humanDate = new Date(Date.UTC(document.beijing2unix.year.value, (stripLeadingZeroes(document.beijing2unix.month.value) - 1), stripLeadingZeroes(document.beijing2unix.day.value), stripLeadingZeroes(document.beijing2unix.hour.value), stripLeadingZeroes(document.beijing2unix.minute.value), stripLeadingZeroes(document.beijing2unix.second.value)));
    document.beijing2unix.result.value = (humanDate.getTime() / 1000 - 8 * 60 * 60);
}
function stripLeadingZeroes(input) {
    if ((input.length > 1) && (input.substr(0, 1) == "0")) {
        return input.substr(1);
    } else {
        return input;
    }
}
function currentTime() {
    var timeNow = new Date();
    document.getElementById("currentunixtime").innerHTML = Math.round(timeNow.getTime() / 1000);
    if (currentTimeActive) {
        unixTimer = setTimeout("currentTime()", 1000);
    }
}
function startTimer() {
    currentTimeActive = 1;
    currentTime();
}
function stopTimer() {
    currentTimeActive = 0;
    clearTimeout(unixTimer);
}
var oSource = document.getElementById("source");
var oShow2 = document.getElementById("show2");
var oTt = document.getElementById("tt");
function action(pChoice){
    switch(pChoice){
        case "CONVERT_FMT1":
            oShow2.value = ascii(oSource.value);
            break;
        case "CONVERT_FMT2":
            oShow2.value = unicode(oSource.value);
            break;
        case "RECONVERT":
            oShow2.value = reconvert(oSource.value);
            break;
    }
}
function ascii(str){
    return str.replace(/[^\u0000-\u00FF]/g,function($0){return escape($0).replace(/(%u)(\w{4})/gi,"\&#x$2;")});
}
function unicode(str){
    return str.replace(/[^\u0000-\u00FF]/g,function($0){return escape($0).replace(/(%u)(\w{4})/gi,"\\u$2")});
}
function reconvert(str){
    str = str.replace(/(\\u)(\w{4})/gi,function($0){
        return (String.fromCharCode(parseInt((escape($0).replace(/(%5Cu)(\w{4})/g,"$2")),16)));
    });

    str = str.replace(/(&#x)(\w{4});/gi,function($0){
        return String.fromCharCode(parseInt(escape($0).replace(/(%26%23x)(\w{4})(%3B)/g,"$2"),16));
    });
    return str;
}
