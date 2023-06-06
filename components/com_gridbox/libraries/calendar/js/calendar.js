window.gridboxCalendar = {
    create: function(){
        this.calendar = document.createElement('div');
        this.calendar.className = 'gridbox-calendar-wrapper';
        this.calendar.innerHTML = '<div class="ba-gridbox-calendar"><div class="ba-gridbox-calendar-title-wrapper">'+
            '<span class="gridbox-calendar-btn"><i class="zmdi zmdi-chevron-left" data-action="prev-year"></i>'+
            '<span class="ba-tooltip ba-bottom ba-hide-element">'+app._('YEAR')+'</span></span>'+
            '<span class="gridbox-calendar-btn"><i class="zmdi zmdi-chevron-left" data-action="prev"></i>'+
            '<span class="ba-tooltip ba-bottom ba-hide-element">'+app._('MONTH')+'</span></span>'+
            '<span class="ba-gridbox-calendar-title"></span>'+
            '<span class="gridbox-calendar-btn"><i class="zmdi zmdi-chevron-right" data-action="next"></i>'+
            '<span class="ba-tooltip ba-bottom ba-hide-element">'+app._('MONTH')+'</span></span>'+
            '<span class="gridbox-calendar-btn"><i class="zmdi zmdi-chevron-right" data-action="next-year"></i>'+
            '<span class="ba-tooltip ba-bottom ba-hide-element">'+app._('YEAR')+'</span></span>'+
            '</div><div class="ba-gridbox-calendar-header"></div>'+
            '<div class="ba-gridbox-calendar-body"></div></div><div class="ba-close-calendar"></div>';
        document.body.appendChild(this.calendar);
        if ('setTooltip' in app) {
            app.setTooltip(this.calendar)
        }
        this.date = new Date();
        this.setEvents();
    },
    setEvents: function(){
        let calendar = this.calendar;
        $g(calendar).on('mousedown', function(event){
            event.stopPropagation();
        }).find('i[data-action]').on('click', function(){
            let year = gridboxCalendar.year * 1,
                month = gridboxCalendar.month * 1;
            if (this.dataset.action == 'next') {
                year = (month === 11) ? year + 1 : year;
                month = (month + 1) % 12;
            } else if (this.dataset.action == 'prev') {
                year = (month === 0) ? year - 1 : year;
                month = (month === 0) ? 11 : month - 1;
            } else if (this.dataset.action == 'next-year') {
                year = year + 1;
            } else if (this.dataset.action == 'prev-year') {
                year = year - 1;
            }
            gridboxCalendar.year = year;
            gridboxCalendar.month = month;
            gridboxCalendar.render();
        });
        $g(calendar).on('click', '.ba-date-cell', function(){
            if (!this.classList.contains('disabled-date')) {
                let value = this.dataset.formated+(!gridboxCalendar.format ? ' '+this.dataset.time : '');
                gridboxCalendar.input.dataset.value = this.dataset.date;
                gridboxCalendar.input.value = value;
                gridboxCalendar.update();
                gridboxCalendar.hide();
            }
        });
        $g(calendar).find('.ba-close-calendar').on('click', function(){
            gridboxCalendar.hide();
        });
    },
    update: function(){
        $g(this.input).trigger('update');
    },
    show: function(input){
        if (!this.calendar) {
            this.create();
        }
        if (input.dataset.year) {
            this.year = input.dataset.year * 1;
            this.month = input.dataset.month * 1;
        } else {
            this.year = this.date.getFullYear();
            this.month = this.date.getMonth();
        }
        this.format = input.dataset.format ? input.dataset.format : '';
        this.input = input;
        this.render().then(function(){
            gridboxCalendar.showCalendar();
        });
    },
    hide: function(){
        this.calendar.classList.remove('visible-gridbox-calendar');
    },
    showCalendar: function(){
        this.calendar.classList.add('visible-gridbox-calendar');
    },
    checkCells: function(){
        let $this = this;
        this.calendar.querySelectorAll('.ba-date-cell').forEach(function(cell){
            let flag = $this.input.disableFunc ? $this.input.disableFunc(cell.dataset.date) : false;
            if ($this.input.dataset.day && cell.dataset.day == $this.input.dataset.day
                && $this.year == $this.input.dataset.year * 1 && $this.month == $this.input.dataset.month * 1) {
                cell.classList.add('ba-curent-date');
            } else if ($this.input.dataset.day) {
                cell.classList.remove('ba-curent-date');
            }
            cell.classList[flag ? 'add' : 'remove']('disabled-date');
        });
    },
    render: function(){
        return new Promise((resolve, reject) => {
            let data = new FormData();
            data.append('start', '1');
            data.append('year', gridboxCalendar.year);
            data.append('month', gridboxCalendar.month * 1 + 1);
            data.append('date_format', gridboxCalendar.format);
            fetch(JUri+'index.php?option=com_gridbox&task=calendar.render', {
                method: 'POST',
                cache: 'no-cache',
                body: data
            }).then(function(request){
                request.text().then(function(text){
                    var data = JSON.parse(text),
                        calendar = gridboxCalendar.calendar,
                        input = gridboxCalendar.input,
                        div = document.createElement('div');
                    div.innerHTML = data.body;
                    calendar.querySelector('.ba-gridbox-calendar-title').textContent = data.title;
                    calendar.querySelector('.ba-gridbox-calendar-header').innerHTML = data.header;
                    calendar.querySelector('.ba-gridbox-calendar-body').innerHTML = div.innerHTML;
                    gridboxCalendar.checkCells();
                    resolve();
                });
            });
        });

    }
}