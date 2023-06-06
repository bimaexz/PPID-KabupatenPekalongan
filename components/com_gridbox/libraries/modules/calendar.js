/**
* @package   Gridbox
* @author    Balbooa http://www.balbooa.com/
* @copyright Copyright @ Balbooa
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

function setupCalendar(input)
{
    let btn = input.nextElementSibling;
    if (!btn) {
        btn = input;
    }
    $g(btn).on('click', function(){
        gridboxCalendar.show(input);
    });
    $g(input).on('update', function(){
        $g(input).trigger('input');
    });
    input.dataset.created = 'true';
}

var file = document.createElement('link');
file.rel = 'stylesheet';
file.href = JUri+'components/com_gridbox/libraries/calendar/css/calendar.css';
document.head.append(file);
file = document.createElement('script');
file.src = JUri+'components/com_gridbox/libraries/calendar/js/calendar.js';
file.onload = function(){
    $g('.open-calendar-dialog').each(function(){
        setupCalendar(this)
    });
}
document.head.append(file);