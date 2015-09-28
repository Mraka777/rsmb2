//get data with ajax
function addmarkdata($mark) {
    
    var w=0;
    var timeouts = [];
    function timeout() {
        if (w<arr.length) {       
            timeouts[w]=setTimeout(function () {
                $(".line"+w).fadeIn();
                w++;
                timeout();
            }, 200-5*w);
            //alert(timeouts[w]);
        }
    }
    
    function delete_timeout() {
        for (t=0; t<timeouts[timeouts.length-1]; t++){
            clearTimeout(t);
        }
    }

    $link = "http://biathlon-manager.com/core/get_mark.php?mark=" + $mark;
    
    var arr = [];

    $.get($link, function(data, status){
        //$('#sportsman_list tr:first').empty();
      delete_timeout();
      
      outp = "<table witdh=\"100%\" id=\"sportsman_list\"><tr><th>Position</th><th>Name</th><th>Country</th><th>Team</th><th>Shooting</th><th>Time</th><th>Behind</th></tr>";
      $("#table_header").html(jQuery.parseHTML(outp));
      ou1 = JSON.parse(JSON.stringify(data));

      //$sportsman_list = jQuery.parseJSON($data)
      //$("#sportsman_list").text(JSON.stringify (data));
      var element;
        for (var i = 0; i < ou1.length; i++) {
            //outp += "<tr>";
            outp2 = "<tr height=\"29\">";
            var object = ou1[i];
            element = [];
            for (property in object) {
                element.push(object[property]);
                //outp += "<td>"+object[property]+"</td>";
                outp2 += "<td align=\"center\"><div id=\"line\" class=\"line"+i+"\" style=\"display:none;\">"+object[property]+"</div></td>";
            }
            arr.push(element);
            //outp += "</tr>";
            outp2 += "</tr>";
            //hide div in table row with id = line0, line1 ...
            
        }
        //outp3="";
        for (j=0; j<arr.length; j++){
            outp3="";
            el = arr[j];
            outp3+= "<tr id=\"line\" align=\"center\" class=\"line"+j+"\" style=\"display:none;\">";
            for (i=0; i<el.length; i++){
                if (i==1) {
                    outp3+="<td align=\"left\">"+el[i]+"</td>";
                }else{
                    outp3+="<td align=\"center\">"+el[i]+"</td>";
                }
            }
            outp3+="</tr>";
            $('#sportsman_list tr:last').after(outp3);
        }
        
        //$('#sportsman_list tr:last').after(outp3);
        //outp+="</table>"
        timeout();
    });


    
    /*for(var q=0; q<15; q++){
        setTimeout(function(){
            $(".line"+q).fadeIn();
            alert(".line"+q);
        }, 400*q);
    }*/
  //setTimeout(function() {
  //  $(".line0").fadeIn();
  //}, 400);
  
  alert(currentMark);
  
   setTimeout(function() {
    nextmark = currentMark + 500;
    //alert(nextmark);
    addmarkdata(nextmark);
  }, 3000);
  
  
}

var showText = function (target, message, index, interval) {   
  if (index < message.length) {
    $(target).append(message[index++]);
    setTimeout(function () { showText(target, message, index, interval); }, interval);
  }
}

$(function () {

  showText("#text_hello", "Добро пожаловать на трассу: ХХХ! Сегодня в рамках Российской лиги №1 состоится первая индивидуальная гонка! В сегодняшней гонке участвует 48 спортсменов, представляющие 16 команд, вот их список:", 0, 50);   

});
