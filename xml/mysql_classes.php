<?php
$db = new PDO('mysql:host=localhost;dbname=yugiv;charset=utf8', 'root', '');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$web="http://localhost/YUGIV/";
	class posts {
		public function simpleSelect($command,$input){
			global $db;
			$command= preg_replace('/[0-9.,`"\'\\;&$%^@!#]/','', $command);
			$query="SELECT * FROM `posts` WHERE ".$command."=".$input." LIMIT 1";
			$dd =$db->prepare($query);
			$dd->execute(array());
			return $dd->fetch(PDO::FETCH_ASSOC);
		}
		public function checkIfPostExists($uid,$name) {
			global $db;
			$query = "SELECT post_id FROM `posts` WHERE user_id=? AND post_id=?";
			$e=$db->prepare($query);
			$e->execute(array($uid,$name));
			$exis=$e->rowCount();
			return ($exis==1)?true:FALSE;
		}
		public function deleteUserPost($uid,$name) {
			global $db;
			$query2="DELETE FROM `posts` WHERE user_id=? AND post_id=?";
			$d=$db->prepare($query2);
			$d->execute(array($uid,$name));
		}
		public function latestPostId(){
			global $db;
			$query2="SELECT post_id FROM posts ORDER BY post_id DESC LIMIT 0, 1 ";
			$pp= $db->query($query2);
			$id=$pp->fetch(PDO::FETCH_ASSOC);
			return $id['post_id'];
		}
		public function submitPost($id,$uid,$title,$view,$type,$content) {
			global $db;
			$time=date('Y-m-d H:i:s');
			$pquery="INSERT INTO `posts`(`post_id`, `user_id`,`title`, `view_option`, `type`, `time`, `content`) VALUES (?,?,?,?,?,?,?)";
			$post =$db->prepare($pquery);
			$post->execute(array($id,$uid,$title,$view,$type,$time,$content));
		}
		public function postUpvotesUpdate($pid,$add) {
			global $db;
			$pc = new posts();
			$pcount= $pc->simpleSelect("post_id", $pid);
			$pcount= $pcount['upvotes']+$add;
			$wquery="UPDATE `posts` SET `upvotes`=? WHERE `post_id`=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pcount,$pid));
		}
		public function postDownvotesUpdate($pid,$add) {
			global $db;
			$pc = new posts();
			$pcount= $pc->simpleSelect("post_id", $pid);
			$pcount= $pcount['downvotes']+$add;
			$wquery="UPDATE `posts` SET `downvotes`=? WHERE `post_id`=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pcount,$pid));
		}
		public function updatePostById($id,$uid,$title,$content) {
			global $db;
			$query="UPDATE `posts` SET `title`=?,`content`=?,`user_id`=? WHERE post_id=?";
			$dd =$db->prepare($query);
			$dd->execute(array($title,$content,$uid,$id));
		}
	}
	class anonymous_posts{
		public function simpleSelect($command,$input){
			global $db;
			$command= preg_replace('/[0-9.,`"\'\\;&$%^@!#]/','', $command);
			$query="SELECT * FROM `anonymous_posts` WHERE ".$command."=".$input." LIMIT 1";
			$dd=$db->prepare($query);
			$dd->execute();
			return $dd->fetch(PDO::FETCH_ASSOC);
		}
		public function confirmUser($pid,$name,$password){
			global $db;
			$query="SELECT * FROM `anonymous_posts` WHERE `post_id`=? AND `name`=? AND `password`=?";
			$dd =$db->prepare($query);
			$dd->execute(array($pid,$name,$password));
			$check=$dd->rowCount();
			return ($check==1)?"true":"false";
		}
		public function update($pid,$name,$password){
			global $db;
			$query="UPDATE `anonymous_posts` SET `name`=?,`password`=? WHERE `post_id`=?";
			$dd =$db->prepare($query);
			$dd->execute(array($name,$password,$pid));
		}
		public function newAnoUser($pid,$aid,$aname,$apass) {
			global $db;
			$query="INSERT INTO `anonymous_posts`(`post_id`, `name`, `password`) VALUES (?,?,?)";
			$dd =$db->prepare($query);
			$dd->execute(array($pid,$aname,$apass));
		}
	}
	class votes {
		private $pid;
		private $cid;
		private $rid;
		function __construct($pid,$cid,$rid) {
			$this->pid=$pid;
			$this->cid=$cid;
			$this->rid=$rid;
		}
		public function userVote($uid){
			global $db;
			$query="SELECT vote FROM `votes` WHERE user_id=? AND post_id=? AND comment_id=? AND reply_id=?";
			$selector=$db->prepare($query);
			$selector->execute(array($uid,$this->pid,$this->cid,$this->rid));
			$voter=$selector->fetch(PDO::FETCH_ASSOC);
			return $voter['vote'];
		}
		public function positiveVotes(){
			global $db;
			$query="SELECT vote FROM `votes` WHERE vote='upvote' AND post_id=? AND comment_id=? AND reply_id=?";
			$pvote=$db->prepare($query);
			$pvote->execute(array($this->pid,$this->cid,$this->rid));
			$pcount=$pvote->rowCount();
			return $pcount;
		}
		public function negativeVotes(){
			global $db;
			$query="SELECT vote FROM `votes` WHERE vote='downvote' AND post_id=? AND comment_id=? AND reply_id=?";
			$nvote=$db->prepare($query);
			$nvote->execute(array($this->pid,$this->cid,$this->rid));
			$ncount=$nvote->rowCount();
			return $ncount;
		}
		public function voteUpdate($uid,$vote){
			global $db;
			$query2="UPDATE `votes` SET `vote`=? WHERE user_id=? AND post_id=? AND comment_id=? AND reply_id=?";
			$final=$db->prepare($query2);
			$final->execute(array($vote,$uid,$this->pid,$this->cid,$this->rid));
		}
		public function voteInsert($uid,$vote){
			global $db;
			$query2="INSERT INTO `votes`(`post_id`, `comment_id`, `reply_id`, `user_id`, `vote`) VALUES (?,?,?,?,?)";
			$final=$db->prepare($query2);
			$final->execute(array($this->pid,$this->cid,$this->rid,$uid,$vote));
		}
		public function voteDelete($uid){
			global $db;
			$query2="DELETE FROM `votes` WHERE user_id=? AND post_id=? AND comment_id=? AND reply_id=?";
			$final=$db->prepare($query2);
			$final->execute(array($uid,$this->pid,$this->cid,$this->rid));
		}
		public function votePostDelete(){
			global $db;
			$query2="DELETE FROM `votes` WHERE post_id=?";
			$final=$db->prepare($query2);
			$final->execute(array($this->pid));
		}
		public function voteCommentDelete(){
			global $db;
			$query2="DELETE FROM `votes` WHERE post_id=? AND comment_id=?";
			$final=$db->prepare($query2);
			$final->execute(array($this->pid,$this->cid));
		}
	}
	class friend_requests{
		private $sender;
		private $receiver;
		function __construct($sender,$receiver) {
			$this->sender=$sender;
			$this->receiver=$receiver;
		}
		public function send(){
			global $db;
			$query="INSERT INTO `friend_requests`(`sending`, `receiving`) VALUES (?,?)";
			$dd =$db->prepare($query);
			$dd->execute(array($this->sender,$this->receiver));
		}
		public function delete(){
			global $db;
			$query="DELETE FROM `friend_requests` WHERE (`sending`=? AND `receiving`=?) OR (`sending`=? AND `receiving`=?)";
			$dd =$db->prepare($query);
			$dd->execute(array($this->sender,$this->receiver,$this->receiver,$this->sender));
		}
		public function checkFriendRequests() {
			global $db;
			$query="SELECT * FROM `friend_requests` WHERE `sending`=? AND `receiving`=?";
			$com=$db->prepare($query);
			$com->execute(array($this->sender,$this->receiver));
			$ccount=$com->rowCount();
			return ($ccount>0)?true:false;
		}
		public function receivedFriendRequests() {
			global $db;
			$query="SELECT * FROM `friend_requests` WHERE `receiving`=?";
			$com=$db->prepare($query);
			$com->execute(array($this->receiver));
			return $com->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class comments{
		public function newCommentUpload($cid, $pid, $uid, $time, $content){
			global $db;
			$query="INSERT INTO `comments`(`comment_id`, `post_id`, `user_id`, `time`, `content`) VALUES (?,?,?,?,?)";
			$selector=$db->prepare($query);
			$selector->execute(array($cid,$pid,$uid,$time,$content));
		}
		public function commentUpvotesUpdate($pid,$cid,$add) {
			global $db;
			$pc = new selectCommentById($pid,$cid);
			$pcount= $pc->array;
			$pcount= $pcount['upvotes']+$add;
			$wquery="UPDATE `comments` SET `upvotes`=? WHERE `post_id`=? AND `coment_id`=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pcount,$pid,$cid));
		}
		public function commentDownvotesUpdate($pid,$cid,$add) {
			global $db;
			$pc = new selectCommentById($pid,$cid);
			$pcount= $pc->array;
			$pcount= $pcount['downvotes']+$add;
			$wquery="UPDATE `comments` SET `downvotes`=? WHERE `post_id`=? AND `comment_id`=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pcount,$pid,$cid));
		}
		function selectCommentById($pid,$cid) {
			global $db;
			$query="SELECT * FROM `comments` WHERE post_id=? AND comment_id=?";
			$dd =$db->prepare($query);
			$dd->execute(array($pid,$cid));
			return $dd->fetch(PDO::FETCH_ASSOC);
		}
		public function checkIfCommentExists($uid,$pid,$cid) {
			global $db;
			$query = "SELECT comment_id FROM `comments` WHERE user_id=? AND post_id=? AND comment_id=?";
			$e=$db->prepare($query);
			$e->execute(array($uid,$pid,$cid));
			$exis=$e->rowCount();
			return($exis==1)?true:FALSE;
		}
		public function updateCommentById($pid,$cid,$content) {
			global $db;
			$query="UPDATE `comments` SET `content`=? WHERE `post_id`=? AND `comment_id`=?";
			$dd =$db->prepare($query);
			$dd->execute(array($content,$pid,$cid));
		}
		public function latestCommentId($pid){
			global $db;
	        $query="SELECT comment_id FROM comments WHERE post_id=".$pid." ORDER BY comment_id DESC LIMIT 0, 1 ";
			$dd= $db->query($query);
			$id= $dd->fetch(PDO::FETCH_ASSOC);
			return (int)$id['comment_id'];
		}
		public function commentUserId($pid,$cid){
			global $db;
			$query="SELECT user_id FROM `comments` WHERE post_id=? AND comment_id=?";
			$dd =$db->prepare($query);
			$dd->execute(array($pid,$cid));
			$this->id=$dd->fetch(PDO::FETCH_ASSOC);
		}
		public function deleteUserComment($uid,$pid,$cid) {
			global $db;
			$query2="DELETE FROM `comments` WHERE user_id=? AND post_id=? AND comment_id=?";
			$d=$db->prepare($query2);
			$d->execute(array($uid,$pid,$cid));
		}
		public function deleteAllComments($pid) {
			global $db;
			$query2="DELETE FROM `comments` WHERE post_id=?";
			$d=$db->prepare($query2);
			$d->execute(array($pid));
		}
	
		public function commentsLoad($pid){
			global $db;
			$query='SELECT * FROM `comments`WHERE comments.post_id=? ORDER BY time DESC';
			$dd =$db->prepare($query);
			$dd->execute(array($pid));
			$this->comments=$dd->fetchAll(PDO::FETCH_ASSOC);
		}
		public function commentsCount($pid){
			global $db;
			$query="SELECT comment_id FROM `comments` WHERE post_id=?";
			$com=$db->prepare($query);
			$com->execute(array($pid));
			$ccount=$com->rowCount();
			return $ccount;
		}
	}
	class selectWithFilter {
		private $order;
		private $rules;
		function __construct($rules,$order) {
			$this->rules=$rules;
			$this->order=$order;
		}
		public function wallPosts($username){
			global $db;
			$query="SELECT DISTINCT posts.post_id,posts.user_id,posts.title,posts.time,posts.type,posts.view_option,posts.upvotes,posts.downvotes,posts.comments,posts.content FROM `posts`,".$username."_wall WHERE ".$username."_wall.id=posts.post_id".$this->rules." ORDER BY posts.".$this->order." DESC";
			$dd =$db->prepare($query);
			$dd->execute();
			return $dd->fetchAll(PDO::FETCH_ASSOC);
		}
		public function userPosts(){
			global $db;
			$query="SELECT DISTINCT posts.post_id,posts.user_id,posts.title,posts.time,posts.type,posts.view_option,posts.upvotes,posts.downvotes,posts.comments,posts.content FROM `posts`,`friends` WHERE 1=1".$rules." ORDER BY ".$order." DESC";
			$dd =$db->prepare($query);
			$dd->execute();
			return $dd->fetchAll(PDO::FETCH_ASSOC);
		}
		public function loadPostsByUserId($id) {
			global $db;
			$query="SELECT DISTINCT posts.post_id,posts.user_id,posts.title,posts.time,posts.type,posts.view_option,posts.upvotes,posts.downvotes,posts.comments,posts.content FROM `posts`,`friends` WHERE posts.user_id=".$id.$this->rules." ORDER BY ".$this->order." DESC";
			$dd =$db->prepare($query);
			$dd->execute();
			return $dd->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class users{
		public function userInfoById($uid){
			global $db;
			$inquery="SELECT * FROM `users` WHERE id=".$uid;
			$userpid=$db->prepare($inquery);
			$userpid->execute();
			$name=$userpid->fetch(PDO::FETCH_ASSOC);
			return $name;
		}
		public function userInfoByUsername($username){
			global $db;
			$inquery="SELECT * FROM `users` WHERE username=?";
			$userpid=$db->prepare($inquery);
			$userpid->execute(array($username));
			$name=$userpid->fetch(PDO::FETCH_ASSOC);
			return $name;
		}
		public function usernameById($uid){
			global $db;
			$userquery="SELECT username FROM `users` WHERE id='".$uid."'";
			$us=$db->query($userquery);
			$username= $us->fetch(PDO::FETCH_ASSOC);
			return $username['username'];
		}
		public function updateProfilePicture($picture,$uid) {
			global $db;
			$query ="UPDATE `users` SET `profile_picture`=? WHERE `id`=?";
			$d=$db->prepare($query);
			$d->execute(array($picture,$uid));
		}
		public function searchUsersByName($input){
			global $db;
			$query="SELECT * FROM users WHERE name LIKE '".$input."%' OR name like '% ".$input."%' OR username LIKE '".$input."%' LIMIT 10";
			$dd =$db->prepare($query);
			$dd->execute();
			return $dd->fetchAll(PDO::FETCH_ASSOC);
		}
		public function checkLog($username,$password) {
			global $db;
			$query="SELECT id FROM users WHERE username=? AND password=?";
			$st =$db->prepare($query);
			$st->execute(array($username,$password));
			return $st-> fetch(PDO::FETCH_ASSOC);
		}
		public function autoUsernameGenerator($username){
			global $db;
			$qusern = "SELECT username FROM `users` WHERE username LIKE '".$username."%' ORDER BY `username` DESC ";
			$un = $db->prepare($qusern);
			$un->execute();
			$transit= $un->fetchAll();
			if(count($transit) > 1){
				$a = $transit[0]['username'];
				str_replace($username, "", $a);
				$a++;
				$username.="$a";
			}elseif(count($transit) == 1){
				$username .="0";
			}
			return $username;
		}
		public function latestUserId(){
			global $db;
			$idquery="SELECT id FROM `users` ORDER BY id DESC";
			$idd=$db->prepare($idquery);
			$idd->execute();
			$idc= $idd->fetch(PDO::FETCH_ASSOC);
			return $idc['id'] +1;
		}
		public function createNewUser($id,$username,$name,$password,$birth){
			global $db;
			global $web;
			$query2="INSERT INTO `users`(`id`,`username`, `name`, `password`, `birth`,`profile`) VALUES (?,?,?,?,?,?)";
			$st =$db->prepare($query2);
			$st->execute(array($id,$username,$name,$password,$birth,$web."profiles/".$username."/posts"));
		}
	}
	class walls {
		public function lastPlacementInUserWall($username) {
			global $db;
			$plquery="SELECT placement FROM `".$username."_wall` ORDER BY placement DESC ";
			$pla=$db->query($plquery);
			$placement= $pla->fetch(PDO::FETCH_ASSOC);
			return $placement['placement'];
		}
		public function insertIntoWall($username,$placement,$pid){
			global $db;
			$wquery="INSERT INTO `".$username."_wall`(`placement`, `id`) VALUES (?,?)";
			$wa=$db->prepare($wquery);
			$wa->execute(array($placement,$pid));
		}
		public function selectFromWall($username,$pid) {
			global $db;
			$wquery="SELECT DISTINCT id FROM `".$username."_wall`WHERE id=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pid));
			return $wa->fetchAll();
		}
		public function createNewWall($username) {
			global $db;
			$query="CREATE table ".$username."_wall(placement INT( 15 ) NOT NULL, id INT( 15 ) NOT NULL);";
			$db->exec($query);
		}
	}
	class friends {
		public function selectUserFriends($username) {
			global $db;
			$fquery="SELECT `friend` FROM `friends` WHERE username=?";
			$dd =$db->prepare($fquery);
			$dd->execute(array($username));
			return $dd->fetchAll();
		}
		public function unfriend($fuser,$suser) {
			global $db;
			$query="DELETE FROM `friends` WHERE (`user_id`=? AND `friend_id`=?) OR (`user_id`=? AND `friend_id`=?)";
			$dd =$db->prepare($query);
			$dd->execute(array($fuser,$suser,$suser,$fuser));
		}
		public function checkFriend($fuser,$suser) {
			global $db;
			$query="SELECT * FROM `friends` WHERE (`user_id`=? AND `friend_id`=?) OR (`user_id`=? AND `friend_id`=?)";
			$com=$db->prepare($query);
			$com->execute(array($fuser,$suser,$suser,$fuser));
			$ccount=$com->rowCount();
			return ($ccount>0)?true:false;
		}
		public function addFriend($user,$sender) {
			global $db;
			$query="INSERT INTO `friends`(`user_id`, `friend_id`) VALUES (?,?)";
			$dd =$db->prepare($query);
			$dd->execute(array($sender,$user));
		}
		public function selectFriends($fuser) {
			global $db;
			$query="SELECT * FROM `friends` WHERE `user_id`=? OR `friend_id`=?";
			$com=$db->prepare($query);
			$com->execute(array($fuser,$fuser));
			return $com->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class follow_info {
		public function selectUserFollowers($uid) {
			global $db;
			$fquery="SELECT user_id FROM `follow_info` WHERE followed_id=?";
			$dd =$db->prepare($fquery);
			$dd->execute(array($uid));
			return $dd->fetchAll();
		}
		public function insertFollow($following,$followed){
			global $db;
			$query="INSERT INTO `follow_info`(`user_id`, `followed_id`) VALUES (?,?)";
			$dd =$db->prepare($query);
			$dd->execute(array($following,$followed));
		}
		public function deleteFollow($following,$followed) {
			global $db;
			$query="DELETE FROM `follow_info` WHERE `user_id`=? AND `followed_id`=?";
			$dd =$db->prepare($query);
			$dd->execute(array($following,$followed));
		}
		public function checkFollow($following,$followed) {
			global $db;
			$query="SELECT * FROM `follow_info` WHERE `user_id`=? AND `followed_id`=?";
			$com=$db->prepare($query);
			$com->execute(array($following,$followed));
			$ccount=$com->rowCount();
			return($ccount>0)?true:false;
		}
		public function selectFollowing($following) {
			global $db;
			$query="SELECT * FROM `follow_info` WHERE `user_id`=?";
			$com=$db->prepare($query);
			$com->execute(array($following));
			return $com->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class selectToolProperties {
		public $array;
		function __construct($post_type) {
			global $db;
			$query="SELECT * FROM `bubble_tool` WHERE `post_type`=?";
			$com=$db->prepare($query);
			$com->execute(array($post_type));
			$this->array=$com->fetch(PDO::FETCH_ASSOC);
		}
	}
	class userToolPreferences{
		public $array;
		function __construct($uid) {
			global $db;
			$query = "SELECT * FROM `user_tool_preferences` WHERE `user_id`=?";
			$com=$db->prepare($query);
			$com->execute(array($uid));
			$this->array=$com->fetch(PDO::FETCH_ASSOC);
		}
	}
	class toolInfo{
		public $array;
		function __construct($type) {
			global $db;
			$query = "SELECT * FROM `bubble_tool` WHERE `post_type`=?";
			$com=$db->prepare($query);
			$com->execute(array($type));
			$this->array=$com->fetch(PDO::FETCH_ASSOC);
		}
	}
	class insertNotification {
		
		function __construct($id,$sender_name,$picture,$link,$text) {
			global $db;
			$query ="INSERT INTO `notifications`(`receiving_id`, `sender_name`, `picture`, `link`, `text`,`time`, `checked`) VALUES (?,?,?,?,?,?,?)";
			$d=$db->prepare($query);
			$d->execute(array($id,$sender_name,$picture,$link,$text,date('Y-m-d H:i:s'),"false"));
		}
	}
	class newUserPreferences{
		function __construct($uid) {
			global $db;
			$query="INSERT INTO `user_tool_preferences`(`user_id`, `first_bubble`, `second_bubble`, `third_bubble`, `fourth_bubble`, `fifth_bubble`, `sixth_bubble`) VALUES (".$uid.",'regular','blog','video','image','file','album')";
			$d=$db->prepare($query);
			$d->execute();
		}
	}
	class checkNotification {
		public $bool;
		function __construct($id) {
			global $db;
			$query ="SELECT * FROM `notifications` WHERE `receiving_id`=? AND `checked`='false'";
			$e=$db->prepare($query);
			$e->execute(array($id));
			$exis=$e->rowCount();
			$this->bool= ($exis > 0)?"true":"false";
		}
	}
	class loadNotifications {
		public $array;
		function __construct($id) {
			global $db;
			$query ="SELECT * FROM `notifications` WHERE `receiving_id`=? ORDER BY `time` DESC";
			$e=$db->prepare($query);
			$e->execute(array($id));
			$this->array=$e->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class readNotification {
		function __construct($id) {
			global $db;
			$query ="UPDATE `notifications` SET `checked`='true' WHERE `receiving_id`=?";
			$e=$db->prepare($query);
			$e->execute(array($id));
		}
	}
	
	
	class insertPhonenumber {
		
		function __construct($id,$phone) {
			global $db;
			$pquery="INSERT INTO `phone_numbers`(`id`, `phone`) VALUES (?,?)";
			$ph =$db->prepare($pquery);
			$ph->execute(array($id,$phone));
		}
	}
	
?>