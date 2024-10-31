jQuery(document).ready( function($)
{
  $('.quatriceps-generate').click(function()
  {
    var qid = '#' + $(this).parent('div').parent('div').attr('id');
    $(qid + ' .quatriceps-output').hide();
    n1 = Math.floor(Math.random() * 1000) + 1;
    n2 = Math.floor(Math.random() * 1000) + 1;
    if(n1 < n2)
    {
      // Switch values
      tmp = n1;
      n1 = n2;
      n2 = tmp;
    }
    $(qid + ' .quatriceps-arg0').val(n1);
    $(qid + ' .quatriceps-arg1').val(n2);
  })

  $('.quatriceps-generate-small-int').click(function()
  {
    var qid = '#' + $(this).parent('div').parent('div').attr('id');
    $(qid + ' .quatriceps-output').hide();
    n1 = Math.floor(Math.random() * 10 * 2) + 1;
    $(qid + ' .quatriceps-arg0').val(n1);
  })

  $('.quatriceps-reveal').click(function()
  {
    var qid = '#' + $(this).parent('div').parent('div').attr('id');
    if($(qid + ' .quatriceps-arg0').val() == '')
    {
     alert('Please enter all required input.');
     return false;
    }

    $(qid + ' .quatriceps-waiting').animate({opacity:1,height:'toggle'});
    $(qid + ' .quatriceps-output').animate({opacity:0,height:'toggle'});
    jQuery.ajax({
      type : 'get',
      url : quatricepsAjax.ajaxurl,
      dataType : 'jsonp',
      data: {
        action: "quatriceps_compute",
        arg0: $(qid + ' .quatriceps-arg0').val(),
        arg1: $(qid + ' .quatriceps-arg1').val(),
        arg2: $(qid + ' .quatriceps-arg2').val(),
        arg3: $(qid + ' .quatriceps-arg3').val(),
        cmd:  $(qid + ' .quatriceps-cmd').val(),
        carry:  $(qid + ' .quatriceps-carry:checked').val(),
        pdf:  $(qid + ' .quatriceps-pdf:checked').val(),
      },
      success : function(data)
      {
        $(qid + ' .quatriceps-output-container').html('<div class="quatriceps-output">' + data.output + '</div><div class="quatriceps-pdf">' + data.pdf + '</div>');
        MathJax.Hub.Queue(["Typeset",MathJax.Hub, qid.substring(1,qid.length)]);
        $(qid + ' .quatriceps-waiting').animate({opacity:0, height:'toggle'});
        $(qid + ' .quatriceps-output').css('display', 'block');
      }
    });
    return false;
  });

  // Randomize sides of compound shape for area
  $('#quatriceps-compoundareal .quatriceps-generate-small-int').click(function()
  {
    n1 = Math.floor(Math.random() * 15) + 1;
    $('#quatriceps-compoundareal img').attr('src', $('#quatriceps-compoundareal img').attr('src').replace(/\\small%20[0-9xy]+/, '\\small%20' + n1));
    $('#quatriceps-compoundareal img').attr('src', $('#quatriceps-compoundareal img').attr('src').replace(/ \\small%20 [0-9xy]+/, ' \\small%20 ' + 2 * n1));
    $('#quatriceps-compoundareal .quatriceps-arg0').val(n1);
  });

  // Randomize sides of compound shape for permimeter
  $('#quatriceps-compoundperimeterl .quatriceps-generate-small-int').click(function()
  {
    n1 = Math.floor(Math.random() * 15) + 1;
    $('#quatriceps-compoundperimeterl img').attr('src', $('#quatriceps-compoundperimeterl img').attr('src').replace(/\\small%20[0-9xy]+/, '\\small%20' + n1));
    $('#quatriceps-compoundperimeterl img').attr('src', $('#quatriceps-compoundperimeterl img').attr('src').replace(/ \\small%20 [0-9xy]+/, ' \\small%20 ' + 2 * n1));
    $('#quatriceps-compoundperimeterl .quatriceps-arg0').val(n1);
  });
}(jQuery));

