<?php

class complist extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render('complist/index', $this->data);
    }

    const TOP = 12;

    public function loadcomp($comp) {
        switch ($comp) {
            case 1: {//last comp
                    $cond = 'isopen=3 ORDER by id DESC Limit ';
                    $this->data['[VARWHICHCOMP]'] = '<div class="none whpg">1</div>';
                    $this->data['[VARKINDCOMP]']='گذشته';
                    break;
                }
            case 2: {//current  comp
                    $cond = 'isopen!=3 AND isopen!=0 ORDER by id DESC Limit ';
                    $this->data['[VARWHICHCOMP]'] = '<div class="none whpg">2</div>';
                    $this->data['[VARKINDCOMP]']='جاری';
                    break;
                }
            case 3: {//next comp
                    $cond = 'isopen=0 ORDER by id DESC Limit ';
                    $this->data['[VARWHICHCOMP]'] = '<div class="none whpg">3</div>';
                    $this->data['[VARKINDCOMP]']='آینده';
                    break;
                }
        }
//        Session::set('cond', $cond);
        $cond.=self::TOP;
        $res = $this->model->loadlastcomp($cond);
        if ($res) {
            $items='';
            while ($row = $res->fetch()) {
                $dvs = $this->loadvs($row['id']);
                if ($row['hasposter'] == 1) {
                    $imgname = Utilities::imgname('poster', $row['id']) . '.jpg';
                    $src = URL . '/images/poster/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('poster', 0) . '.jpg';
                    $src = URL . '/images/poster/' . $imgname;
                }
                $items.='<div class="col-md-4 col-xs-12 floatright maindiv">
				<div class="card">
                                 <div class="card-content text-right">
			            <span class="card-title">مسابقه <a href="' . URL . 'comp/id/' . $row['id'] . '"> ' . $row['name'] . ' </a> </span>                    
			        </div><!-- card content -->
			        <div class="card-image">
			            <img class="img-responsive" src="' . $src . '" />
			        </div><!-- card image -->
			        
			        <div class="card-action">                                    
			            <span style="font-size: 12px;color: #D6D6D6;">' . AntiXSS::clean_up(Shamsidate::jdate(' j F Y', $row['startdate'])) . ' تا ' . AntiXSS::clean_up(Shamsidate::jdate(' j F Y', $row['enddate'])) . '</span>
                                    <button type="button" id="show" class="btn btn-custom pull-left">
			                <span class="glyphicon glyphicon-plus"></span>
			            </button>
			        </div><!-- card actions -->
			        <div class="card-reveal">
			            <span class="card-title">مسابقه <a href="' . URL . 'comp/id/' . $row['id'] . '"> ' . $row['name'] . ' </a> </span> <button type="button" style="font-size: 40px;" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			            <div class="card-details">
			            	<div class="text-details">
			            		<span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . ' </span>
			            	</div>
			            	<hr />
			            	<div class="date-details">
			            		<span>شروع: </span><span class="details-color1">' . AntiXSS::clean_up(Shamsidate::jdate(' j F Y', $row['startdate'])) . '</span>
				            	<span>پایان: </span><span class="details-color1">' . AntiXSS::clean_up(Shamsidate::jdate(' j F Y', $row['enddate'])) . '</span>
			            	</div>
			            	<div class="go-details">
			            		<span>تعداد راه یافته به داوری:</span>
			            		<span class="details-color1">' . $row['davarino'] . ' قطعه</span>
			            	</div>
			            	<div class="winner-details">
			            		<span>تعداد برندگان:</span>
			            		<span class="details-color1">' . $row['winno'] . ' قطعه</span>
			            	</div>
			            	<div class="elect-details">
			            		<span>تعداد منتخبین:</span>
			            		<span class="details-color1">' . $row['selno'] . ' قطعه</span>
			            	</div>
			            	<div class="sendimg-details">
			            		<span>تعداد عکس های ارسالی:</span>
			            		<span class="details-color1">' . $row['numofpic'] . ' قطعه</span>
			            	</div>
			            	<div class="awards-details">
			            		<span>جوایز:</span>
			            		<span class="details-color1">' . $row['prise'] . '</span>
			            	</div>' . $dvs . '
			            	
			            </div>
			        </div><!-- card reveal -->
			    </div>
			</div>';
            }
            $this->data['[VARCOMPLIST]'] = $items;
            $this->index();
        }else{
            $this->index();
        }
        
    }

    public function loadvs($cid) {
        $res = $this->model->loadvs($cid);
        $dlist = '';
        if ($res) {
            $dlist = '<div class="ghazi-details">
			            		<span>داوران: </span>';
            while ($row = $res->fetch()) {
                if ($row['name'] != '' && $row['family'] != '') {
                    $davarname = htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']);
                } else {
                    $davarname = $row['username'];
                }
                $dlist.='<span><a href="' . URL . 'blog/id/' . $row['did'] . '">' . $davarname . '</a></span>  |  ';
            }
        }
        $dlist = substr($dlist, 0, strlen($dlist) - 3);
        $dlist.='</div>';
        return $dlist;
    }

    public function paging() {
        if (isset($_POST['pgid'])) {
            $lmt = self::TOP * ($_POST['pgid'] - 1);
            switch ($_POST['whichpg']) {
                case 1: {
                    $cond = 'isopen=3 ORDER by id DESC Limit :lmt , :top';    
                    break;
                    }
                    case 2: {
                    $cond = 'isopen!=3 AND isopen!=0 ORDER by id DESC Limit :lmt , :top';    
                    break;
                    }
                    case 3: {
                    $cond = 'isopen=0 ORDER by id DESC Limit :lmt , :top';    
                    break;
                    }
            }
            $condata = array('lmt' => $lmt, 'top' => self::TOP);
            $res = $this->model->loadlastcomp($cond, $condata);
            if ($res) {
                $items = '';
                while ($row = $res->fetch()) {
                    $dvs = $this->loadvs($row['id']);
                    if ($row['hasposter'] == 1) {
                        $imgname = Utilities::imgname('poster', $row['id']) . '.jpg';
                        $src = URL . '/images/poster/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('poster', 0) . '.jpg';
                        $src = URL . '/images/poster/' . $imgname;
                    }
                    $items.='<div class="col-md-4 col-xs-12 floatright maindiv">
				<div class="card">
			        <div class="card-image">
			            <img class="img-responsive" src="' . $src . '" />
			        </div><!-- card image -->
			        
			        <div class="card-content text-right">
			            <span class="card-title">مسابقه <a href="' . URL . 'comp/id/' . $row['id'] . '"> ' . $row['name'] . ' </a> </span>                    
			        </div><!-- card content -->
			        <div class="card-action ">
			            <button type="button" id="show" class="btn btn-custom pull-left" aria-label="Left Align">
			                <i class="glyphicon glyphicon-option-vertical"></i>
			            </button>
			            <span class="">' . AntiXSS::clean_up(Shamsidate::jdate(' j F Y', $row['startdate'])) . ' تا ' . AntiXSS::clean_up(Shamsidate::jdate(' j F Y', $row['enddate'])) . '</span>
			            
			        </div><!-- card actions -->
			        <div class="card-reveal">
			            <span class="card-title">مسابقه <a href="' . URL . 'comp/id/' . $row['id'] . '"> ' . $row['name'] . ' </a>  </span> <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			            <div class="card-details">
			            	<div class="text-details">
			            		<span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . ' </span>
			            	</div>
			            	<hr />
			            	<div class="date-details">
			            		<span>شروع: </span><span class="details-color1">' . AntiXSS::clean_up(Shamsidate::jdate(' j F Y', $row['startdate'])) . '</span>
				            	<span>پایان: </span><span class="details-color1">' . AntiXSS::clean_up(Shamsidate::jdate(' j F Y', $row['enddate'])) . '</span>
			            	</div>
			            	<div class="go-details">
			            		<span>تعداد راه یافته به داوری:</span>
			            		<span class="details-color1">' . $row['davarino'] . ' قطعه</span>
			            	</div>
			            	<div class="winner-details">
			            		<span>تعداد برندگان:</span>
			            		<span class="details-color1">' . $row['winno'] . ' قطعه</span>
			            	</div>
			            	<div class="elect-details">
			            		<span>تعداد منتخبین:</span>
			            		<span class="details-color1">' . $row['selno'] . ' قطعه</span>
			            	</div>
			            	<div class="sendimg-details">
			            		<span>تعداد عکس های ارسالی:</span>
			            		<span class="details-color1">' . $row['numofpic'] . ' قطعه</span>
			            	</div>
			            	<div class="awards-details">
			            		<span>جوایز:</span>
			            		<span class="details-color1">' . $row['prise'] . '</span>
			            	</div>' . $dvs . '
			            	
			            </div>
			        </div><!-- card reveal -->
			    </div>
			</div>';
                }
                $this->view->render('complist/index',  json_encode(array('items'=>$items)) , FALSE, 0);
            }
        }
    }

}
