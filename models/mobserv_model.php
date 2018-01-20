<?php
class mobserv_model extends Model{
    function __construct() {
        parent::__construct();
    }
    public function others($cond=null,$condata=array()) {
        return $this->db->select('tbl_comp','*',$cond,$condata);
    }
    public function loadlastcomp($cond,$condata) {
        return $this->db->select('tbl_photos','*',$cond,$condata);
    }
    
    public function selectuser($id){
        $cond='id=:id';
        $condata=array('id'=>$id);
        return $this->db->select('tbl_users','*',$cond,$condata);
    }
    public function loadvs($comp) {
        $cond='compid=:compid';
        $condata=array('compid'=>$comp);
        return $this->db->select('foridx','*',$cond,$condata);
    }
    
    
    public function gcmsave($gcm,$cond,$condata){
        $updata=array('gcmid'=>$gcm);
        return $this->db->update('tbl_users',$updata,$cond,$condata);
    }
    
    
    public function loadrate($pid,$uid) {
        $cond = 'uid=:uid AND pid=:pid';
        $condata = array('uid' => $uid,'pid' => $pid);
        return $this->db->select('tbl_ratemardomi', '*', $cond, $condata);
    }
    
    public function winrate($cond, $condata) {
        return $this->db->select('tbl_wins', '*', $cond, $condata);
    }

    
    public function searchphot($cond ,$condata=array()){
        return $this->db->select('photosearch','*',$cond ,$condata);
    }
    
    public function selectcomp(){
        $cond='isopen!=:isopen';
        $condata=array('isopen'=>0);
        return $this->db->select('tbl_comp','*',$cond,$condata);
    }
    
    
    public function selectcompnow(){
        $cond='isopen=:isopen';
        $condata=array('isopen'=>1);
        return $this->db->select('tbl_comp','*',$cond,$condata);
    }
    
    public function selectstates(){
        return $this->db->select('tbl_states','*');
    }
    
    public function checkcomp($id){
        $cond='id=:id AND isopen=1';
        $condata=array('id'=>$id);
        return $this->db->select('tbl_comp','*',$cond,$condata);
    }
    
    public function saveimage($data) {
        return $this->db->insert('tbl_photos',$data);
    }
    public function citynam($cond,$condata) {
        return $this->db->select('tbl_states','*',$cond,$condata);
    }
    
    
    public function edituser($id){
        $cond='id=:id';
        $condata=array('id'=>$id);
        $res=$this->db->select('tbl_users','photonumber',$cond,$condata);
        $row=$res->fetch();
        $newnumber=$row['photonumber']+1;
        $updata=array('photonumber'=>$newnumber);
        $cond='id=:id';
        $condata=array('id'=>$id);
        return $this->db->update('tbl_users',$updata,$cond,$condata);
    }
    
    public function score($cond,$condata) {
        return $this->db->select('tbl_score','*',$cond,$condata);
    }
    
    public function wins($cond,$condata) {
        return $this->db->select('tbl_wins','*',$cond,$condata);
    }
    
    public function saveeditprof($updata,$cond,$condata){
        return $this->db->update('tbl_users',$updata,$cond,$condata);
    }
    
    public function selectusername($cond,$condata){
        return $this->db->select('tbl_users','*',$cond,$condata);
    }
    
    public function checkmelicode($melicode,$userid) {
        $data=array('melicode'=>$melicode,'id'=>$userid);
        $cond='id!=id AND melicode=:melicode';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    
    public function checkmobile($mobile) {
        $data=array('mobile'=>$mobile);
        $cond='mobile=:mobile';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    
    public function login($data) {
        $cond='username=:username AND password=:password';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    
    public function setlogininfo($data,$cond,$condata) {
        return $this->db->update('tbl_users',$data,$cond,$condata);
    }
    
    public function checkuser($username) {
        $data=array('username'=>$username);
        $cond='username=:username';
        return $this->db->select('tbl_users','*',$cond,$data);
    }
    
    public function register($data) {
        return $this->db->insert('tbl_users',$data);
    }
    
    public function saveuser($data) {
        return $this->db->insert('tbl_score',$data);
    }
    
    public function saveactivecode($data) {
        return $this->db->insert('tbl_active',$data);
    }
    
    public function checkactcode($id){
        $cond='activecode=:activecode';
        $condata=array('activecode'=>$id);
        return $this->db->select('tbl_active','*',$cond,$condata);
    }
    
    public function deletecode($id){
        $cond='activecode=:activecode';
        $condata=array('activecode'=>$id);
         $this->db->delete('tbl_active',$cond,$condata);
    }
    
    public function makeuseractive($id){
        $updata=array('confirm'=>1);
        $cond='id=:id';
        $condata=array('id'=>$id);
        return $this->db->update('tbl_users',$updata,$cond,$condata);
    }
    
    public function selecactivecod($cond, $condata) {
        return $this->db->select('tbl_activecod', '*', $cond, $condata);
    }
    
    public function updatenewpass($data, $cond, $condata) {
        $this->db->update('tbl_activecod', $data, $cond, $condata);
    }
    
    public function insertnewpass($data) {
        return $this->db->insert('tbl_activecod', $data);
    }
    
    public function selectcod($cond, $condata) {
        return $this->db->select('tbl_activecod', '*', $cond, $condata);
    }
    
    public function delactivcod($cond) {
        return $this->db->delete('tbl_activecod',$cond);
    }
    
    public function selectedcod($cond, $condata) {
        return $this->db->select('tbl_activecod', '*', $cond, $condata);
    }
    
    public function selecteduser($cond) {
        return $this->db->select('tbl_users', '*', $cond);
    }
    
    public function editregister($updata, $cond, $condata) {
        $this->db->update('tbl_users', $updata, $cond, $condata);
    }
    
    
    public function slenotmob($userid){
        $cond='uid=:uid';
        $condata=array('uid'=>$userid);
        return $this->db->select('whonots', '*', $cond,$condata);
    }
    
    
    public function loads() {
        return $this->db->select('tbl_files', '*');
    }
    
    public function loadabout($field) {
        return $this->db->select('tbl_about',$field);
    }
    
    public function load() {
        return $this->db->select('tbl_question', '*');
    }
    
    public function loadmethod() {
        return $this->db->select('tbl_method', '*');
    }
    
    public function loadrules() {
        return $this->db->select('tbl_policy','*');
    }
    
    public function loadcpy() {
        return $this->db->select('tbl_copyright','*');
    }
    
    public function loadaddress() {
        return $this->db->select('tbl_contact', '*');
    }
    
    public function saveform($data){
        return $this->db->insert('tbl_formcontact',$data);
    }
    
    public function bazbinrate($imgid){
        $cond='imgid=:imgid';
        $condata=array('imgid'=>$imgid);
        return $this->db->select('tbl_bazbinrate','*',$cond,$condata);
    }
    
    public function selrate($id,$userid) {
        $cond = 'pid=:pid and uid=:uid';
        $condata = array('pid' => $id,'uid'=>$userid);
        return $this->db->select('tbl_ratemardomi', '*', $cond, $condata);
    }
    
    public function uprate($uid, $id, $rate) {
        $updata = array('rate' => $rate);
        $condata = array('pid' => $id, 'uid' => $uid);
        $cond = 'pid=:pid AND uid=:uid';
        return $this->db->update('tbl_ratemardomi', $updata, $cond, $condata);
    }
    
    public function saverate($data) {
        return $this->db->insert('tbl_ratemardomi', $data);
    }
    
    public function seluser($id) {
        $cond = 'pid=:pid';
        $condata = array('pid' => $id);
        return $this->db->select('tbl_ratemardomi', '*', $cond, $condata);
    }
    
    public function uprefate($id, $rate) {
        $updata = array('imglike' => $rate);
        $condata = array('id' => $id);
        $cond = 'id=:id';
        return $this->db->update('tbl_photos', $updata, $cond, $condata);
    }
    public function checkcompeftekhar($id){
        $cond='id=:id';
        $condata=array('id'=>$id);
        return $this->db->select('tbl_comp','*',$cond,$condata);
    }
    
    public function checkflw($cond,$condata){
        return $this->db->select('tbl_follow','*',$cond,$condata);
    }
    
    public function makeflw($data){
        return $this->db->insert('tbl_follow',$data);
    }
    public function makeunflw($cond,$condata){
        return $this->db->delete('tbl_follow',$cond,$condata);
    }
    
    public function selfing($cond,$condata) {
        return $this->db->select('viw_fing','*',$cond,$condata);
    }
    public function selfer($cond,$condata) {
        return $this->db->select('viw_fer','*',$cond,$condata);
    }
    
    public function saveviolation($data) {
        return $this->db->insert('tbl_violation', $data);
    }
}