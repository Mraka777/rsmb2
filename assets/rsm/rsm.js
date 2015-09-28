
  
  function runSeconds(source, target, message) {

    seconds_left = parseInt(document.getElementById(source).value);

    //seconds_left = parseInt(0.25 * seconds_left);
    
    hours = parseInt(seconds_left/3600);
    
    if (hours < 0) {
      hours = 0;
    }
    if (hours < 10) {
      hours = '0' + hours;
    }
    
    pom = seconds_left%3600;
    
    minutes = parseInt(pom/60);
    if (minutes < 0) {
      minutes = 0;
    }
    if (minutes < 10) {
      minutes = '0' + minutes;
    }
    
    seconds = pom%60;
    if (seconds < 0) {
      seconds = 0;
    }
    if (seconds < 10) {
      seconds = '0' + seconds;
    }
    
    document.getElementById(target).innerHTML = hours + ":" + minutes + ":" + seconds;
    document.getElementById(source).value = parseInt(document.getElementById(source).value) - 1;

    if (document.getElementById(source).value > 0) {
      timerID = setTimeout("runSeconds('" + source + "', '" + target + "', '" + message + "')", 1000);
    } else {
      document.getElementById(target).innerHTML = message;
    }
    
  
  }