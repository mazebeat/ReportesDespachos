
(function() {
  "use strict";

// custom scrollbar

$("html").niceScroll({styler:"fb",cursorcolor:"#65cea7", cursorwidth: '6', cursorborderradius: '0px', background: '#424f63', spacebarenabled:false, cursorborder: '0',  zindex: '1000'});

$(".left-side").niceScroll({styler:"fb",cursorcolor:"#65cea7", cursorwidth: '3', cursorborderradius: '0px', background: '#424f63', spacebarenabled:false, cursorborder: '0'});


$(".left-side").getNiceScroll();
if ($('body').hasClass('left-side-collapsed')) {
  $(".left-side").getNiceScroll().hide();
}



// Toggle Left Menu
jQuery('.menu-list > a').click(function() {

  var parent = jQuery(this).parent();
  var sub = parent.find('> ul');

  if(!jQuery('body').hasClass('left-side-collapsed')) {
    if(sub.is(':visible')) {
      sub.slideUp(200, function(){
        parent.removeClass('nav-active');
        jQuery('.main-content').css({height: ''});
        mainContentHeightAdjust();
      });
    } else {
      visibleSubMenuClose();
      parent.addClass('nav-active');
      sub.slideDown(200, function(){
        mainContentHeightAdjust();
      });
    }
  }
  return false;
});

function visibleSubMenuClose() {
  jQuery('.menu-list').each(function() {
    var t = jQuery(this);
    if(t.hasClass('nav-active')) {
      t.find('> ul').slideUp(200, function(){
        t.removeClass('nav-active');
      });
    }
  });
}

function mainContentHeightAdjust() {
// Adjust main content height
var docHeight = jQuery(document).height();
if(docHeight > jQuery('.main-content').height())
  jQuery('.main-content').height(docHeight);
}

//  class add mouse hover
jQuery('.custom-nav > li').hover(function(){
  jQuery(this).addClass('nav-hover');
}, function(){
  jQuery(this).removeClass('nav-hover');
});


// Menu Toggle
jQuery('.toggle-btn').click(function(){
  $(".left-side").getNiceScroll().hide();

  if ($('body').hasClass('left-side-collapsed')) {
    $(".left-side").getNiceScroll().hide();
  }
  var body = jQuery('body');
  var bodyposition = body.css('position');

  if(bodyposition != 'relative') {

    if(!body.hasClass('left-side-collapsed')) {
      body.addClass('left-side-collapsed');
      jQuery('.custom-nav ul').attr('style','');

      jQuery(this).addClass('menu-collapsed');

    } else {
      body.removeClass('left-side-collapsed chat-view');
      jQuery('.custom-nav li.active ul').css({display: 'block'});

      jQuery(this).removeClass('menu-collapsed');

    }
  } else {

    if(body.hasClass('left-side-show'))
      body.removeClass('left-side-show');
    else
      body.addClass('left-side-show');

    mainContentHeightAdjust();
  }

});


searchform_reposition();

jQuery(window).resize(function(){

  if(jQuery('body').css('position') == 'relative') {

    jQuery('body').removeClass('left-side-collapsed');

  } else {

    jQuery('body').css({left: '', marginRight: ''});
  }

  searchform_reposition();

});

function searchform_reposition() {
  if(jQuery('.searchform').css('position') == 'relative') {
    jQuery('.searchform').insertBefore('.left-side-inner .logged-user');
  } else {
    jQuery('.searchform').insertBefore('.menu-right');
  }
}

// panel collapsible
$('.panel .tools .fa').click(function () {
  var el = $(this).parents(".panel").children(".panel-body");
  if ($(this).hasClass("fa-chevron-down")) {
    $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
    el.slideUp(200);
  } else {
    $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
    el.slideDown(200); }
  });

$('.todo-check label').click(function () {
  $(this).parents('li').children('.todo-title').toggleClass('line-through');
});

$(document).on('click', '.todo-remove', function () {
  $(this).closest("li").remove();
  return false;
});

$("#sortable-todo").sortable();


// panel close
$('.panel .tools .fa-times').click(function () {
  $(this).parents(".panel").parent().remove();
});



// tool tips

$('.tooltips').tooltip();

// popovers

$('.popovers').popover();



})(jQuery);

AmCharts.makeChart("chartdiv",
{
  "type": "pie",
  "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
  "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
  "titleField": "country",
  "valueField": "litres",
  "fontSize": 10,
  "theme": "default",
  "allLabels": [],
  "balloon": {},
  "titles": [],
  "dataProvider": [
  {
    "country": "Boleta",
    "litres": "54785"
  },
  {
    "country": "Factura",
    "litres": "57261"
  },
  {
    "country": "Nota de credito",
    "litres": "54367"
  }
  ]
}
);

AmCharts.makeChart("chartdiv2",
{
  "type": "pie",
  "pathToImages": "http://cdn.amcharts.com/lib/3/images/",
  "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
  "titleField": "country",
  "valueField": "litres",
  "fontSize": 10,
  "theme": "default",
  "allLabels": [],
  "balloon": {},
  "titles": [],
  "dataProvider": [
  {
    "country": "Ciclo",
    "litres": "547852"
  },
  {
    "country": "No Ciclo",
    "litres": "57261"
  },
  ]
}
);


AmCharts.makeChart("chartdiv3",
{
  "type": "serial",
  "pathToImages": "http://live.amcharts.com/new/edit/#//cdn.amcharts.com/lib/3/images/",
  "categoryField": "date",
  "columnSpacing": 2,
  "dataDateFormat": "YYYY-MM",
  "autoMarginOffset": 0,
  "marginLeft": 19,
  "plotAreaBorderColor": "#FFFFFF",
  "borderColor": "#FFFFFF",
  "fontFamily": "sans-serif",
  "fontSize": 10,
  "handDrawScatter": 0,
  "handDrawThickness": 0,
  "theme": "default",
  "categoryAxis": {
    "minPeriod": "MM",
    "parseDates": true
  },
  "chartCursor": {
    "categoryBalloonDateFormat": "MMM YYYY"
  },
  "chartScrollbar": {},
  "trendLines": [],
  "graphs": [
  {
    "bullet": "round",
    "columnWidth": 0,
    "id": "AmGraph-1",
    "title": "graph 1",
    "valueAxis": "ValueAxis-1",
    "valueField": "column-1"
  }
  ],
  "guides": [],
  "valueAxes": [
  {
    "id": "ValueAxis-1",
    "title": "Axis title"
  }
  ],
  "allLabels": [],
  "amExport": {},
  "balloon": {},
  "legend": {
    "useGraphSettings": true
  },
  "titles": [
  {
    "color": "#000000",
    "id": "lead",
    "size": 15,
    "text": "Fija"
  }
  ],
  "dataProvider": [
  {
    "date": "2014-01",
    "column-1": 8,
    "column-2": 5
  },
  {
    "date": "2014-02",
    "column-1": 6,
    "column-2": 7
  },
  {
    "date": "2014-03",
    "column-1": 2,
    "column-2": 3
  },
  {
    "date": "2014-04",
    "column-1": 1,
    "column-2": 3
  },
  {
    "date": "2014-05",
    "column-1": 2,
    "column-2": 1
  },
  {
    "date": "2014-06",
    "column-1": 3,
    "column-2": 2
  },
  {
    "date": "2014-07",
    "column-1": 6,
    "column-2": 8
  }
  ]
}
);
