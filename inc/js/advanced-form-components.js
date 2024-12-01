//date picker start

    if (top.location != location) {
        top.location.href = document.location.href ;
    }
    $(function(){
        window.prettyPrint && prettyPrint();
        $('.default-date-picker').datepicker({
            format: 'mm-dd-yyyy'
        });
        $('.dpYears').datepicker();
        $('.dpMonths').datepicker();


        var startDate = new Date(2012,1,20);
        var endDate = new Date(2012,1,25);
        $('.dp4').datepicker()
            .on('changeDate', function(ev){
                if (ev.date.valueOf() > endDate.valueOf()){
                    $('.alert').show().find('strong').text('Inicio no puede ser m�s grande que final.');
                } else {
                    $('.alert').hide();
                    startDate = new Date(ev.date);
                    $('#startDate').text($('.dp4').data('date'));
                }
                $('.dp4').datepicker('hide');
            });
        $('.dp5').datepicker()
            .on('changeDate', function(ev){
                if (ev.date.valueOf() < startDate.valueOf()){
                    $('.alert').show().find('strong').text('No menor a la fecha.');
                } else {
                    $('.alert').hide();
                    endDate = new Date(ev.date);
                    $('.endDate').text($('.dp5').data('date'));
                }
                $('.dp5').datepicker('hide');
            });

        // disabling dates
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkin = $('.dpd1').datepicker({
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
                if (ev.date.valueOf() > checkout.date.valueOf()) {
                    var newDate = new Date(ev.date)
                    newDate.setDate(newDate.getDate() + 1);
                    checkout.setValue(newDate);
                }
                checkin.hide();
                $('.dpd2')[0].focus();
            }).data('datepicker');
        var checkout = $('.dpd2').datepicker({
            onRender: function(date) {
                return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev) {
                checkout.hide();
            }).data('datepicker');
    });

//date picker end


//datetime picker start
if ($(".form_datetime").length > 0) {
  $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
}


if ($(".form_datetime-component").length > 0) {
  $(".form_datetime-component").datetimepicker({
      format: "dd MM yyyy - hh:ii"
  });
}

if ($(".form_datetime-adv").length > 0) {
  $(".form_datetime-adv").datetimepicker({
      format: "dd MM yyyy - hh:ii",
      autoclose: true,
      todayBtn: true,
      startDate: "2013-02-14 10:00",
      minuteStep: 10
  });
}

if ($(".form_datetime-meridian").length > 0) {
  $(".form_datetime-meridian").datetimepicker({
      format: "dd MM yyyy - HH:ii P",
      showMeridian: true,
      autoclose: true,
      todayBtn: true
  });
}

//datetime picker end

//timepicker start
if ($('.timepicker-default').length > 0) {
  $('.timepicker-default').timepicker();
}

if ($('.timepicker-24').length > 0) {
  $('.timepicker-24').timepicker({
      autoclose: true,
      minuteStep: 1,
      showSeconds: true,
      showMeridian: false
  });
}


//timepicker end

//colorpicker start

if ($('.colorpicker-default').length > 0) {
  $('.colorpicker-default').colorpicker({
      format: 'hex'
  });
}

if ($('.colorpicker-rgba').length > 0) {
  $('.colorpicker-rgba').colorpicker();
}

//colorpicker end

//multiselect start

    if ($('#my_multi_select1').length > 0) {
      $('#my_multi_select1').multiSelect();
    }
    if ($('#my_multi_select2').length > 0) {
      $('#my_multi_select2').multiSelect({
          selectableOptgroup: true
      });
    }

    if ($('#my_multi_select3').length > 0) {
      $('#my_multi_select3').multiSelect({
          selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          afterInit: function (ms) {
              var that = this,
                  $selectableSearch = that.$selectableUl.prev(),
                  $selectionSearch = that.$selectionUl.prev(),
                  selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                  selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

              that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                  .on('keydown', function (e) {
                      if (e.which === 40) {
                          that.$selectableUl.focus();
                          return false;
                      }
                  });

              that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                  .on('keydown', function (e) {
                      if (e.which == 40) {
                          that.$selectionUl.focus();
                          return false;
                      }
                  });
          },
          afterSelect: function () {
              this.qs1.cache();
              this.qs2.cache();
          },
          afterDeselect: function () {
              this.qs1.cache();
              this.qs2.cache();
          }
      });
    }

//multiselect end


//spinner start
if ($('#spinner1').length > 0) {
  $('#spinner1').spinner();
}

if ($('#spinner2').length > 0) {
  $('#spinner2').spinner({disabled: true});
}

if ($('#spinner3').length > 0) {
  $('#spinner3').spinner({value:0, min: 0, max: 10});
}

if ($('#spinner4').length > 0) {
  $('#spinner4').spinner({value:0, step: 5, min: 0, max: 200});
}

//spinner end



//wysihtml5 start
if ($('.wysihtml5').length > 0) {
  $('.wysihtml5').wysihtml5();
}

//wysihtml5 end
