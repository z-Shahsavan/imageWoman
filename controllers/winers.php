<?php

class winers extends Controller {

    function __construct() {

        parent::__construct();
    }

    public function index() {
        $this->finishedcomp();
        $this->view->render('winers/index', $this->data);
    }

    public function finishedcomp() {
        $montakhaban = '';
        $winners = '';
        $winnermar = '';
        $this->data['[VARASAMIBARANDEGAN]'] = '';
        $cond = 'isopen=3';
        $res = $this->model->comps($cond);
        if ($res != FALSE) {
            $montakhaban .='  <tr>
                                            <th>نام و نام خانوادگی</th>
                                        </tr>';
            $winners .='  <tr>
                                            <th>نام و نام خانوادگی</th>
                                            <th>رتبه و جایزه</th>
                                
                                        </tr>';
            while ($row = $res->fetch()) {
                if ($row['hasposter'] == 1) {
                    $imgname = Utilities::imgname('poster', $row['id']) . '.jpg';
                    $src = URL . '/images/poster/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('poster', 0) . '.jpg';
                    $src = URL . '/images/poster/' . $imgname;
                }
                $cond = 'confirm=1 AND (iswin=2 OR iswin=5) AND compid=:compid ';
                $condata = array('compid' => $row['id']);
//                echo $row['id'];
                $resmon = $this->model->montakhaban($cond, $condata);
            
                if ($resmon != FALSE) {
                    while ($rowmon = $resmon->fetch()) {
                        $montakhaban .= '<tr>
                                            <td>' . $rowmon['uname'] . ' ' . $rowmon['uf'] . '</td>
                                           </tr>';
                    }
                }
                $cond = 'confirm=1 AND compid=:compid AND(iswin=1 OR iswin=3 OR iswin=4)';
                $condata = array('compid' => $row['id']);
                $reswin = $this->model->montakhaban($cond, $condata);
                if ($reswin != FALSE) {
                        $winners='';
                    while ($rowwin = $reswin->fetch()) {
                        $jayeze = '';
                        $win = '';
                        $jayezearray = array();
                        $cond = 'imgid=:imgid ORDER BY wintype ASC';
                        $condata = array('imgid' => $rowwin['pid']);
                        $resjayeze = $this->model->loadjayeze($cond, $condata);
                        $jayeze = '<br>جوایز:';
                        $jayezearray = array();
                        $i = 0;
                        if ($resjayeze != FALSE) {
                            while ($rowjayeze = $resjayeze->fetch()) {
                                $jayeze.=$rowjayeze['price'] . '<br>';
                                $jayezearray[$i] = $rowjayeze['rate'];
                                $i++;
                            }
                   //     }
                        switch ($rowwin['iswin']) {
                            case 1:

                                $win = 'برنده داوری رتبه:' . $jayezearray[0];
                                break;
                            case 3:
                                $win = 'برنده مردمی';

                                break;
                            case 4:
                                $win = 'برنده داوری رتبه:' . $jayezearray[0] . ' -برنده مردمی';

                                break;
                        }
                        $win.=$jayeze;
                        $winners .= '  <tr>
                                          <td>' . $rowwin['uname'] . ' ' . $rowwin['uf'] . '</td>
                                          <td>' . $win . '</td>

                                        </tr>';
                                    }
                    }
                }
                $this->data['[VARASAMIBARANDEGAN]'] .= '<div class="col-md-4 col-xs-12 floatright">
                    <div class="card">
                        <div class="card-image">
                            <img class="img-responsive" src="' . $src . '" />
                        </div> 
                        <div class="card-content text-right">
                            <span class="card-title">' . $row['name'] . '</span>                    
                        </div>
                        <div class="card-action ">
                            <button type="button" id="show" class="btn btn-custom pull-left" aria-label="Left Align">
                                مشاهده
                            </button>
                            <span class="">تاریخ پایان:' . AntiXSS::clean_up(Shamsidate::jdate(' j F Y', $row['enddate'])) . '</span>
        
                        </div> 
                        <div class="card-reveal">
                            <span class="card-title">' . $row['name'] . '</span> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <ul class="nav nav-tabs naving">
                                <li class="active"><a data-toggle="tab" href="#bdavari' . $row['id'] . '">منتخب داوری</a></li>
                                <li><a data-toggle="tab" href="#barande' . $row['id'] . '">برنده</a></li>
                            </ul>
                            <div class="tab-content tab-contenting">
                                <div id="bdavari' . $row['id'] . '" class="tab-pane fade in active">
                                    <table class="table">
                                       ' . $montakhaban . '
                                    </table>
                                </div>
                                <div id="barande' . $row['id'] . '" class="tab-pane fade">
                                    <table class="table">
                                         ' . $winners . '
                                    </table>
                                </div>
                               
                            </div>
                        </div> 
                    </div>
                </div>';
            }
        }
    }

}
