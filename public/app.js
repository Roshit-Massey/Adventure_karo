var availableColor = {
    "1": "#e8938e",
    "2": '#ea837c',
    "3": "#f5746b",
    "4": "#f1655c",
    "5": "#d2534b",
    "6": "#CF382D",
    "7": "#C3342A",
    "8": "#c3372e",
    "9": "#B63128",
    "10": "#9a0a00"
}

var errors = [];
var successToasts = [];
var pageNoCollection = [];
var limitCollection = [];
var totalPages = [];
var trid = $(document).find('table').attr('id');

pageNoCollection[0] = 1;
limitCollection[0] = 10;

function SHA1(msg){

    function rotate_left(n,s){var t4=(n<<s)|(n>>>(32-s));return t4;};function lsb_hex(val){var str='';var i;var vh;var vl;for(i=0;i<=6;i+=2){vh=(val>>>(i*4+4))&0x0f;vl=(val>>>(i*4))&0x0f;str+=vh.toString(16)+vl.toString(16);} 
    return str;};function cvt_hex(val){var str='';var i;var v;for(i=7;i>=0;i--){v=(val>>>(i*4))&0x0f;str+=v.toString(16);} 
    return str;};function Utf8Encode(string){string=string.replace(/\r\n/g,'\n');var utftext='';for(var n=0;n<string.length;n++){var c=string.charCodeAt(n);if(c<128){utftext+=String.fromCharCode(c);} 
    else if((c>127)&&(c<2048)){utftext+=String.fromCharCode((c>>6)|192);utftext+=String.fromCharCode((c&63)|128);} 
    else{utftext+=String.fromCharCode((c>>12)|224);utftext+=String.fromCharCode(((c>>6)&63)|128);utftext+=String.fromCharCode((c&63)|128);}} 
    return utftext;};var blockstart;var i,j;var W=new Array(80);var H0=0x67452301;var H1=0xEFCDAB89;var H2=0x98BADCFE;var H3=0x10325476;var H4=0xC3D2E1F0;var A,B,C,D,E;var temp;msg=Utf8Encode(msg);var msg_len=msg.length;var word_array=new Array();for(i=0;i<msg_len-3;i+=4){j=msg.charCodeAt(i)<<24|msg.charCodeAt(i+1)<<16|msg.charCodeAt(i+2)<<8|msg.charCodeAt(i+3);word_array.push(j);} 
    switch(msg_len % 4){case 0:i=0x080000000;break;case 1:i=msg.charCodeAt(msg_len-1)<<24|0x0800000;break;case 2:i=msg.charCodeAt(msg_len-2)<<24|msg.charCodeAt(msg_len-1)<<16|0x08000;break;case 3:i=msg.charCodeAt(msg_len-3)<<24|msg.charCodeAt(msg_len-2)<<16|msg.charCodeAt(msg_len-1)<<8|0x80;break;} 
    word_array.push(i);while((word_array.length % 16)!=14)word_array.push(0);word_array.push(msg_len>>>29);word_array.push((msg_len<<3)&0x0ffffffff);for(blockstart=0;blockstart<word_array.length;blockstart+=16){for(i=0;i<16;i++)W[i]=word_array[blockstart+i];for(i=16;i<=79;i++)W[i]=rotate_left(W[i-3]^W[i-8]^W[i-14]^W[i-16],1);A=H0;B=H1;C=H2;D=H3;E=H4;for(i=0;i<=19;i++){temp=(rotate_left(A,5)+((B&C)|(~B&D))+E+W[i]+0x5A827999)&0x0ffffffff;E=D;D=C;C=rotate_left(B,30);B=A;A=temp;} 
    for(i=20;i<=39;i++){temp=(rotate_left(A,5)+(B^C^D)+E+W[i]+0x6ED9EBA1)&0x0ffffffff;E=D;D=C;C=rotate_left(B,30);B=A;A=temp;} 
    for(i=40;i<=59;i++){temp=(rotate_left(A,5)+((B&C)|(B&D)|(C&D))+E+W[i]+0x8F1BBCDC)&0x0ffffffff;E=D;D=C;C=rotate_left(B,30);B=A;A=temp;} 
    for(i=60;i<=79;i++){temp=(rotate_left(A,5)+(B^C^D)+E+W[i]+0xCA62C1D6)&0x0ffffffff;E=D;D=C;C=rotate_left(B,30);B=A;A=temp;} 
    H0=(H0+A)&0x0ffffffff;H1=(H1+B)&0x0ffffffff;H2=(H2+C)&0x0ffffffff;H3=(H3+D)&0x0ffffffff;H4=(H4+E)&0x0ffffffff;} 
    var temp=cvt_hex(H0)+cvt_hex(H1)+cvt_hex(H2)+cvt_hex(H3)+cvt_hex(H4);return temp.toLowerCase();
} 

function getFlagEmoji(countryCode) {
    return countryCode.toUpperCase().replace(/./g, function(char){ return String.fromCodePoint(127397 + char.charCodeAt()) } );
}

function addedHis(str){
    return str.split("-").reverse().join("-")+" 00:00:00";
}

function splitToChangeDateFormat(date){
    var data = date.split('-');
    return data[2].split("T")[0]+"-"+data[1]+"-"+data[0];
}

function yearMonthDate(date){
    var data = date.split('-');
    return data[2]+"-"+data[1]+"-"+data[0];
}

function format(date) {
    date = new Date(date);
    var day = ('0' + date.getDate()).slice(-2);
    var month = ('0' + (date.getMonth() + 1)).slice(-2);
    var year = date.getFullYear();
    return day + '-' + month + '-' + year;
}

function differentDateFormat(f){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; 
    var yyyy = today.getFullYear();
    if(dd<10) dd='0'+dd;
    if(mm<10) mm='0'+mm;
    if(f == 1) today = mm+'-'+dd+'-'+yyyy;
    if(f == 2) today = mm+'/'+dd+'/'+yyyy;
    if(f == 3) today = dd+'-'+mm+'-'+yyyy;
    if(f == 4) today = dd+'/'+mm+'/'+yyyy;
    if(f == 5) today = yyyy+'-'+mm+'-'+dd;
    return today;
}

var dataFormat = function(date){
    const months = ["JAN", "FEB", "MAR","APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
    let current_datetime = new Date(date);
    let formatted_date = current_datetime.getDate() + "-" + months[current_datetime.getMonth()] + "-" + current_datetime.getFullYear()
    return formatted_date;
}

function toHHMMSS(secs){
    var sec_num = parseInt(secs, 10)
    var hours   = Math.floor(sec_num / 3600)
    var minutes = Math.floor(sec_num / 60) % 60
    var seconds = sec_num % 60
    return [hours,minutes,seconds].map(function(v) { return v < 10 ? "0" + v : v}).join(":")
}

function showLoader() {
    $('#loader-wrap').css({"display":"block"});
}

function hideLoader() {
    $('#loader-wrap').css({"display":"none"});
}

function getCurrentTime() {
    //AM - PM Format
    var currentTime = new Date()
    var hours = currentTime.getHours()
    var minutes = currentTime.getMinutes()

    if (minutes < 10)
        minutes = "0" + minutes;

    var suffix = "AM";
    if (hours >= 12) {
        suffix = "PM";
        hours = hours - 12;
    }
    if (hours == 0) {
        hours = 12;
    }
    var current_time = hours + ":" + minutes + " " + suffix;
    return current_time;
}

function AM_PM(date) {
    //AM - PM Format
    var currentTime = new Date(date)
    var hours = currentTime.getHours()
    var minutes = currentTime.getMinutes()

    if (minutes < 10)
        minutes = "0" + minutes;

    var suffix = "AM";
    if (hours >= 12) {
        suffix = "PM";
        hours = hours - 12;
    }
    if (hours == 0) {
        hours = 12;
    }
    if (hours < 10) {
        hours = "0" + hours;
    }
    var current_time = hours + ":" + minutes + " " + suffix;
    return current_time;
}


var getColor = function(percentage)  {
    if(percentage <= 33.33)
        return '#CC402B';
    if((percentage > 33.33 && percentage <= 66.66))
        return '#F29255';
    if((percentage > 66.66 && percentage <= 100))
        return '#7cc761';
}

var clearErrors = function(key){
    if(key){
        successToasts.splice(successToasts.indexOf(key), 1);
        if(successToasts.length == 0)
            $('#showToast').html('');
    }
    $('#toast-error #desc #errorList').html('');
    for(var key in errors){
        $('#' + key).removeClass('is-invalid');
    }
    errors = [];
}
var validatePhoneNumber = function(mobile){
  var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    if(mobile.match(phoneno) == false){
        return false;
    }
    return true;
}

var CheckIsValidDomain = function(domain) { 
	var re = new RegExp(/^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$/); 
	return domain.match(re);
} 

var validateEmail = function(emailField) {
    var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (reg.test(emailField) == false) {
        return false;
    }
    return true;
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

Number.prototype.pad = function(size) {
    var s = String(this);
    while (s.length < (size || 2)) {s = "0" + s;}
    return s;
}

function secondsToTime(secs){
    var hours = Math.floor(secs / (60 * 60));
   
    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);
 
    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);
    
    return hours.pad()+":"+minutes.pad()+":"+seconds.pad();
}

function downloadCSV(fileName, content){
    const items = content;
    const replacer = function(key, value){ return value === null ? '' : value} 
    const header = Object.keys(items[0])
    let csv = items.map(function(row) { return header.map(function(fieldName){ return JSON.stringify(row[fieldName], replacer)}).join(',') })
    csv.unshift(header.join(','))
    csv = csv.join('\r\n')

    var link = document.createElement("a");    
    link.id="lnkDwnldLnk";
    document.body.appendChild(link);
    blob = new Blob([csv], { type: 'text/csv' }); 
    var csvUrl = window.webkitURL.createObjectURL(blob);
    var filename = fileName+'.csv';
    jQuery("#lnkDwnldLnk")
    .attr({
        'download': filename,
        'href': csvUrl
    });
    jQuery('#lnkDwnldLnk')[0].click();
    document.body.removeChild(link);
}

function copyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
  
    textArea.style.position = 'fixed';
    textArea.style.top = 0;
    textArea.style.left = 0;
    textArea.style.width = '2em';
    textArea.style.height = '2em';
    textArea.style.padding = 0;
    textArea.style.border = 'none';
    textArea.style.outline = 'none';
    textArea.style.boxShadow = 'none';
    textArea.style.background = 'transparent';
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.select();
    try {
      var successful = document.execCommand('copy');
      var msg = successful ? 'successful' : 'unsuccessful';
      console.log('Copying text command was ' + msg);
    } catch (err) {
      console.log('Oops, unable to copy');
    }
    document.body.removeChild(textArea);
}

function isPageHidden(){
    return document.hidden || document.msHidden || document.webkitHidden || document.mozHidden;
}

var hasError = function(){
    return Object.keys(errors).length > 0;
}

var addErrorToList = function(msg){
    $('#toast-error #errorList').append('<li>'+msg+'</li>');
}

var addError = function(key, msg){
    errors[key] = msg;
}

var showErrors = function(){
    for(var key in errors){
        $('#' + key).addClass('is-invalid');
        addErrorToList(errors[key]);
    }
    launchToast('error');
}

var isURL = function(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+ // domain name
    '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
    '(\\:\\d+)?(\\/[-a-z\\d=%_.~+]*)*'+ // port and path
    '(\\?[;&a-zA-Z0-9\\d%_.~+=-]*)?'+ // query string
    '(\\#[-a-zA-Z0-9\\d_]*)?$','i'); // fragment locator
    return pattern.test(str);
}

function launchToast(type) {
    $('.toast-box').show();

    successToasts.push(type);
    if(!type || type == 'success'){
        type = '';
    }else if(type == 'error'){
        type = '-error';
    }
    $('#toast'+type).addClass('show');
    // $('html, body').animate({scrollTop:0},500);
    setTimeout(function(){ 
        $('.toast-box').hide();
        $('#toast'+type).removeClass('show'); 
        clearErrors(type);
     }, 3000);
}

function showError(msg){
    clearErrors();
    if(msg != undefined){
        if(msg.message != undefined){
            addErrorToList(msg.message);
        }else{
            addErrorToList(msg);
        }
    }else{
        addErrorToList('Something went wrong!');                
    }
    launchToast('error');
}

function showAPIError(errorCode, msg){
    clearErrors();
    if(errorCode == 500 || errorCode == 401 || errorCode == 403){
        if(msg.errors != undefined){
            var count = 0;
            msg.errors.forEach(function(err){
                addError(++count, err);
            });
            hasError() && showErrors();
        }else{
            addError('ERR', msg);
            hasError() && showErrors();
        }
    }else if(errorCode == 400){
        if(msg.isJoi){
            var count = 0;
            msg.details.forEach(function(detail){
                addError(count++, detail.message);
            });
            showErrors();
        }
    }
}

function timeInAgoFormat(date) {
    var seconds = Math.floor((new Date() - date) / 1000);
    var interval = Math.floor(seconds / 31536000);
    if (interval > 1) {
        return interval + " years";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + " months";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + " days";
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + " hours";
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + " minutes";
    }
    return Math.floor(seconds) + " seconds";
}

function makeid(length) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  
    for (var i = 0; i < length; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));
  
    return text;
  }

function showSuccess(msg){
    $('#showToast').html('');
    var randomId = makeid(5);
    var html = '<div class="toast show" id="toast'+randomId+'" role="alert" aria-live="assertive" aria-atomic="true" data-delay="1000"> <div class="toast-body"><span style="color:forestgreen"><i class="fa fa-check-circle"></i> '+msg+'</span></div> </div>';
    $('#showToast').append(html);
    launchToast(randomId);
}

function isNumber(evt){
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) 
        return false;
    return true; 
}

function sanitize(input) {
    return input.replace(/<(|\/|[^>\/bi]|\/[^>bi]|[^\/>][^>]+|\/[^>][^>]+)>/g, '');
}

var xssClean = function(str){
    return $.parseHTML(str);
}
function urlParam(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results == null) return null;
    else return decodeURI(results[1]) || 0;
}

function comingsoon(){
    swal({ title: 'Coming Soon!'})
}
