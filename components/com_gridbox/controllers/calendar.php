<?php
/**
* @package   Gridbox
* @author    Balbooa http://www.balbooa.com/
* @copyright Copyright @ Balbooa
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class gridboxControllerCalendar extends JControllerForm
{
    protected $zone;

    public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

    public function render()
    {
        $input = JFactory::getApplication()->input;
        $year = $input->get('year', '0', 'string');
        $month = $input->get('month', '0', 'string');
        $format = $input->get('date_format', 'Y-m-d', 'raw');
        if (empty($format)) {
            $format = 'Y-m-d';
        }
        if (strlen($month) == 1) {
            $month = '0'.$month;
        }
        $offset = JFactory::getConfig()->get('offset');
        $this->zone = new DateTimeZone($offset);
        $date = JDate::getInstance($year.'-'.$month.'-01', $this->zone);
        $obj = $this->getCalendar($date, $month, $year, 1, $format);
        $str = json_encode($obj);
        header('Content-Type: text/javascript');
        echo $str;
        exit;
    }

    public function getCalendar($dateObject, $month, $year, $start = 1, $format = 'Y-m-d')
    {
        $end = $start + 6;
        $obj = new stdClass();
        $dateData = new stdClass();
        $dateData->days = array(JText::_('SUN'), JText::_('MON'), JText::_('TUE'), JText::_('WED'), JText::_('THU'),
            JText::_('FRI'), JText::_('SAT'), JText::_('SUN'));
        $today = date('j');
        $now = JDate::getInstance('now', $this->zone);
        $nowDate = new stdClass();
        $nowDate->date = $now->format('n Y', true);
        $nowDate->year = $now->format('Y', true);
        $nowDate->month = $now->format('n', true);
        $m = strlen($nowDate->month) == 1 ? '0'.$nowDate->month : $nowDate->month;
        $todayDate = $dateObject->format('n Y', true);
        $time = $now->format('H:i:s', true);
        $obj->title = $dateObject->format('F Y', true);
        $obj->header = '';
        for ($i = $start; $i <= $end; $i++) { 
            $obj->header .= '<div class="ba-calendar-day-name">'.$dateData->days[$i].'</div>';
        }
        $obj->body = '';
        $firstDay = $dateObject->format('w', true);
        if ($firstDay == 0 && $start == 1) {
            $firstDay = 7;
        }
        $daysInMonth = $dateObject->format('t', true);
        $day = 1;
        for ($i = 0; $i < 6; $i++) {
            if ($day > $daysInMonth) {
                break;
            }
            $obj->body .= '<div class="ba-gridbox-calendar-row">';
            for ($j = $start; $j <= $end; $j++) {
                if (($i === 0 && $j < $firstDay) || $day > $daysInMonth) {
                    $obj->body .= '<div class="ba-empty-date-cell"></div>';
                } else {
                    $d = $day < 10 ? '0'.(string)$day : (string)$day;
                    $JDate = JDate::getInstance($year.'-'.$month.'-'.$d, $this->zone);
                    $date = $JDate->format('Y-m-d', true);
                    $formated = $JDate->format($format, true);
                    $obj->body .= '<div class="ba-date-cell';
                    if ($day == $today && $nowDate->date == $todayDate) {
                        $obj->body .= ' ba-curent-date';
                    }
                    $obj->body .= '" data-day="'.$d.'" data-date="'.$date.'" data-formated="'.$formated.'" data-time="'.$time.'">'.$day.'</div>';
                    $day++;
                }
            }
            $obj->body .= '</div>';
        }

        return $obj;
    }
}