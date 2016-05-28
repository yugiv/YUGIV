<?php
$db = new PDO('mysql:host=localhost;dbname=yugiv;charset=utf8', 'root', '');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$web="http://localhost/YUGIV/";
	class latestCommentID{
		public $cid;
    	function __construct($pid) {
    		global $db;
	        $query="SELECT comment_id FROM comments WHERE post_id=".$pid." ORDER BY comment_id DESC LIMIT 0, 1 ";
			$dd= $db->query($query);
			$id= $dd->fetch(PDO::FETCH_ASSOC);
			$this->cid=(int)$id['comment_id'];
      	}
	}
	class newCommentUpload{
		function __construct($cid, $pid, $uid, $time, $content){
			global $db;
			$query="INSERT INTO `comments`(`comment_id`, `post_id`, `user_id`, `time`, `content`) VALUES (?,?,?,?,?)";
			$selector=$db->prepare($query);
			$selector->execute(array($cid,$pid,$uid,$time,$content));
			return 1;
		}
	}
	class commentsLoad{
		public $comments;
		function __construct($pid){
			global $db;
			$query='SELECT * FROM `comments`WHERE comments.post_id=? ORDER BY time DESC';
			$dd =$db->prepare($query);
			$dd->execute(array($pid));
			$this->comments=$dd->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class userVote {
		public $vote;
		function __construct($uid, $pid, $cid, $rid) {
			global $db;
			$query="SELECT vote FROM `votes` WHERE user_id=? AND post_id=? AND comment_id=? AND reply_id=?";
			$selector=$db->prepare($query);
			$selector->execute(array($uid,$pid,$cid,$rid));
			$voter=$selector->fetch(PDO::FETCH_ASSOC);
			$this->vote= $voter['vote'];
		}
	}
	class bigNumbersKiller {
		public $result;
		function __construct($number) {
			$pcount=$number;
			if($pcount>=1000000000000){
				$pcount=(substr(substr(($pcount/1000000000000), 0, 4), -1)==".")?substr(($pcount/1000000000000), 0, 3):substr(($pcount/1000000000000), 0, 4);
				$pcount .='T';
			}else if($pcount>=1000000000){
				$pcount=(substr(substr(($pcount/1000000000), 0, 4), -1)==".")?substr(($pcount/1000000000), 0, 3):substr(($pcount/1000000000), 0, 4);
				$pcount .='B';
		    }else if($pcount>=1000000){
		    	$pcount=(substr(substr(($pcount/1000000), 0, 4), -1)==".")?substr(($pcount/1000000), 0, 3):substr(($pcount/1000000), 0, 4);
		    	$pcount .='M';
		    }else if($pcount>=1000){
		    	$pcount=(substr(substr(($pcount/1000), 0, 4), -1)==".")?substr(($pcount/1000), 0, 3):substr(($pcount/1000), 0, 4);
		    	$pcount .='K';
			}
			$this->result =$pcount;
		}
	}
	
	class positiveVotes{
		public $pcount;
		function __construct($pid,$cid,$rid) {
			global $db;
			$query="SELECT vote FROM `votes` WHERE vote='upvote' AND post_id=? AND comment_id=? AND reply_id=?";
			$pvote=$db->prepare($query);
			$pvote->execute(array($pid,$cid,$rid));
			$pcount=$pvote->rowCount();
			$this->pcount=$pcount;
		}
	}
	class negativeVotes{
		public $ncount;
		function __construct($pid,$cid,$rid) {
			global $db;
			$query="SELECT vote FROM `votes` WHERE vote='downvote' AND post_id=? AND comment_id=? AND reply_id=?";
			$nvote=$db->prepare($query);
			$nvote->execute(array($pid,$cid,$rid));
			$ncount=$nvote->rowCount();
			$this->ncount=$ncount;
		}
	}
	class commentsCount{
		public $ccount;
		function __construct($pid) {
			global $db;
			$query="SELECT comment_id FROM `comments` WHERE post_id=?";
			$com=$db->prepare($query);
			$com->execute(array($pid));
			$ccount=$com->rowCount();
			$this->ccount=$ccount;
		}
	}
	class selectWallPosts {
		public $array;
		function __construct($username,$order,$rules) {
			global $db;
			$query="SELECT DISTINCT posts.post_id,posts.user_id,posts.title,posts.time,posts.type,posts.view_option,posts.upvotes,posts.downvotes,posts.comments,posts.content FROM `posts`,".$username."_wall WHERE ".$username."_wall.id=posts.post_id".$rules." ORDER BY posts.".$order." DESC";
			$dd =$db->prepare($query);
			$dd->execute();
			$this->array=$dd->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class selectAllPosts {
		public $array;
		function __construct($order,$rules) {
			global $db;
			$query="SELECT DISTINCT posts.post_id,posts.user_id,posts.title,posts.time,posts.type,posts.view_option,posts.upvotes,posts.downvotes,posts.comments,posts.content FROM `posts`,`friends` WHERE 1=1".$rules." ORDER BY ".$order." DESC";
			$dd =$db->prepare($query);
			$dd->execute();
			$this->array=$dd->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class userInfo {
		public $user;
		function __construct($uid) {
			global $db;
			$inquery="SELECT * FROM `users` WHERE id=".$uid;
			$userpid=$db->prepare($inquery);
			$userpid->execute();
			$name=$userpid->fetch(PDO::FETCH_ASSOC);
			$this->user=$name;
		}
	}
	class voteUpdate {
		
		function __construct($vote,$uid,$pid,$cid,$rid) {
			global $db;
			$query2="UPDATE `votes` SET `vote`=? WHERE user_id=? AND post_id=? AND comment_id=? AND reply_id=?";
			$final=$db->prepare($query2);
			$final->execute(array($vote,$uid,$pid,$cid,$rid));
		}
	}
	class voteInsert {
		
		function __construct($vote,$uid,$pid,$cid,$rid) {
			global $db;
			$query2="INSERT INTO `votes`(`post_id`, `comment_id`, `reply_id`, `user_id`, `vote`) VALUES (?,?,?,?,?)";
			$final=$db->prepare($query2);
			$final->execute(array($pid,$cid,$rid,$uid,$vote));
		}
	}
	class voteDelete {
		
		function __construct($uid,$pid,$cid,$rid) {
			global $db;
			$query2="DELETE FROM `votes` WHERE user_id=? AND post_id=? AND comment_id=? AND reply_id=?";
			$final=$db->prepare($query2);
			$final->execute(array($uid,$pid,$cid,$rid));
		}
	}
	class votePostDelete {
		
		function __construct($pid) {
			global $db;
			$query2="DELETE FROM `votes` WHERE post_id=?";
			$final=$db->prepare($query2);
			$final->execute(array($pid));
		}
	}
	class voteCommentDelete {
		
		function __construct($pid,$cid) {
			global $db;
			$query2="DELETE FROM `votes` WHERE post_id=? AND comment_id";
			$final=$db->prepare($query2);
			$final->execute(array($pid,$cid));
		}
	}
	class userUsername {
		public $username;
		function __construct($uid) {
			global $db;
			$userquery="SELECT username FROM `users` WHERE id='".$uid."'";
			$us=$db->query($userquery);
			$username= $us->fetch(PDO::FETCH_ASSOC);
			$this->username= $username['username'];
		}
	}
	class userId {
		public $uid;
		function __construct($username) {
			global $db;
			$userquery="SELECT id FROM `users` WHERE username='".$username."'";
			$us=$db->query($userquery);
			$username= $us->fetch(PDO::FETCH_ASSOC);
			$this->uid= $username['id'];
		}
	}
	class latestPostId {
		public $id;
		function __construct() {
			global $db;
			$query2="SELECT post_id FROM posts ORDER BY post_id DESC LIMIT 0, 1 ";
			$pp= $db->query($query2);
			$id=$pp->fetch(PDO::FETCH_ASSOC);
			$this->id= $id['post_id'];
		}
	}
	class submitPost {
		
		function __construct($id,$uid,$title,$view,$type,$content) {
			global $db;
			$time=date('Y-m-d H:i:s');
			$pquery="INSERT INTO `posts`(`post_id`, `user_id`,`title`, `view_option`, `type`, `time`, `content`) VALUES (?,?,?,?,?,?,?)";
			$post =$db->prepare($pquery);
			$post->execute(array($id,$uid,$title,$view,$type,$time,$content));
		}
	}
	class lastPlacementInUserWall {
		public $placement;
		function __construct($username) {
			global $db;
			$plquery="SELECT placement FROM `".$username."_wall` ORDER BY placement DESC ";
			$pla=$db->query($plquery);
			$placement= $pla->fetch(PDO::FETCH_ASSOC);
			$this->placement= $placement['placement'];
		}
	}
	class insertIntoWall {
		
		function __construct($username,$placement,$pid) {
			global $db;
			$wquery="INSERT INTO `".$username."_wall`(`placement`, `id`) VALUES (?,?)";
			$wa=$db->prepare($wquery);
			$wa->execute(array($placement,$pid));
		}
	}
	class selectFromWall {
		public $array;
		function __construct($username,$pid) {
			global $db;
			$wquery="SELECT DISTINCT id FROM `".$username."_wall`WHERE id=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pid));
			$this->array = $wa->fetchAll();
		}
	}
	class selectUserFriends {
		public $friends;
		function __construct($username) {
			global $db;
			$fquery="SELECT `friend` FROM `friends` WHERE username=?";
			$dd =$db->prepare($fquery);
			$dd->execute(array($username));
			$this->friends = $dd->fetchAll();
		}
	}
	class selectUserFollowers {
		public $follower;
		function __construct($username) {
			global $db;
			$fquery="SELECT user_id FROM `follow_info` WHERE followed_id=?";
			$dd =$db->prepare($fquery);
			$dd->execute(array($username));
			$this->follower = $dd->fetchAll();
		}
	}
	class postUpvotesUpdate {
		
		function __construct($pid,$add) {
			global $db;
			$pc = new selectPostById($pid);
			$pcount= $pc->array;
			$pcount= $pcount['upvotes']+$add;
			$wquery="UPDATE `posts` SET `upvotes`=? WHERE `post_id`=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pcount,$pid));
		}
	}
	class postDownvotesUpdate {
		
		function __construct($pid,$add) {
			global $db;
			$pc = new selectPostById($pid);
			$pcount= $pc->array;
			$pcount= $pcount['downvotes']+$add;
			$wquery="UPDATE `posts` SET `downvotes`=? WHERE `post_id`=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pcount,$pid));
		}
	}
	class commentUpvotesUpdate {
		
		function __construct($pid,$cid,$add) {
			global $db;
			$pc = new selectCommentById($pid,$cid);
			$pcount= $pc->array;
			$pcount= $pcount['upvotes']+$add;
			$wquery="UPDATE `comments` SET `upvotes`=? WHERE `post_id`=? AND `comment_id`=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pcount,$pid,$cid));
		}
	}
	class commentDownvotesUpdate {
		
		function __construct($pid,$cid,$add) {
			global $db;
			$pc = new selectCommentById($pid,$cid);
			$pcount= $pc->array;
			$pcount= $pcount['downvotes']+$add;
			$wquery="UPDATE `comments` SET `downvotes`=? WHERE `post_id`=? AND `comment_id`=?";
			$wa=$db->prepare($wquery);
			$wa->execute(array($pcount,$pid,$cid));
		}
	}
	class searchUsersByName {
		public $output;
		function __construct($input) {
			global $db;
			$query="SELECT * FROM users WHERE name LIKE '".$input."%' OR name like '% ".$input."%' OR username LIKE '".$input."%' LIMIT 10";
			$dd =$db->prepare($query);
			$dd->execute();
			$this->output = $dd->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class loadPostsByUserId {
		public $array;
		function __construct($id,$order,$rules) {
			global $db;
			$query="SELECT DISTINCT posts.post_id,posts.user_id,posts.title,posts.time,posts.type,posts.view_option,posts.upvotes,posts.downvotes,posts.comments,posts.content FROM `posts`,`friends` WHERE posts.user_id=".$id.$rules." ORDER BY ".$order." DESC";
			$dd =$db->prepare($query);
			$dd->execute();
			$this->array=$dd->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class checkLog {
		public $array;
		public $dis;
		function __construct($username,$password) {
			global $db;
			$query="SELECT id FROM users WHERE username=? AND password=?";
			$st =$db->prepare($query);
			$st->execute(array($username,$password));
			$this->array=$st-> fetch(PDO::FETCH_ASSOC);
			$this->dis=$username;
		}
	}
	class selectPostById {
		public $array;
		function __construct($id) {
			global $db;
			$query="SELECT * FROM `posts` WHERE post_id=?";
			$dd =$db->prepare($query);
			$dd->execute(array($id));
			$this->array=$dd->fetch(PDO::FETCH_ASSOC);
		}
	}
	class updatePostById {
		function __construct($id,$title,$content) {
			global $db;
			$query="UPDATE `posts` SET `title`=?, `content`=? WHERE post_id=?";
			$dd =$db->prepare($query);
			$dd->execute(array($title,$content,$id));
		}
	}
	class selectCommentById {
		public $array;
		function __construct($pid,$cid) {
			global $db;
			$query="SELECT * FROM `comments` WHERE post_id=? AND comment_id=?";
			$dd =$db->prepare($query);
			$dd->execute(array($pid,$cid));
			$this->array=$dd->fetch(PDO::FETCH_ASSOC);
		}
	}
	class updateCommentById {
		function __construct($pid,$cid,$content) {
			global $db;
			$query="UPDATE `comments` SET `content`=? WHERE `post_id`=? AND `comment_id`=?";
			$dd =$db->prepare($query);
			$dd->execute(array($content,$pid,$cid));
		}
	}
	class sendFriendRequest {
		function __construct($sender,$receiver) {
			global $db;
			$query="INSERT INTO `friend_requests`(`sending`, `receiving`) VALUES (?,?)";
			$dd =$db->prepare($query);
			$dd->execute(array($sender,$receiver));
		}
	}
	class deleteFriendRequest {
		function __construct($sender,$receiver) {
			global $db;
			$query="DELETE FROM `friend_requests` WHERE (`sending`=? AND `receiving`=?) OR (`sending`=? AND `receiving`=?)";
			$dd =$db->prepare($query);
			$dd->execute(array($sender,$receiver,$receiver,$sender));
		}
	}
	class unfriend {
		function __construct($fuser,$suser) {
			global $db;
			$query="DELETE FROM `friends` WHERE (`user_id`=? AND `friend_id`=?) OR (`user_id`=? AND `friend_id`=?)";
			$dd =$db->prepare($query);
			$dd->execute(array($fuser,$suser,$suser,$fuser));
		}
	}
	class checkFriend {
		public $check;
		function __construct($fuser,$suser) {
			global $db;
			$query="SELECT * FROM `friends` WHERE (`user_id`=? AND `friend_id`=?) OR (`user_id`=? AND `friend_id`=?)";
			$com=$db->prepare($query);
			$com->execute(array($fuser,$suser,$suser,$fuser));
			$ccount=$com->rowCount();
			$this->check=($ccount>0)?true:false;
		}
	}
	class checkFriendRequests {
		public $check;
		function __construct($sending,$receiving) {
			global $db;
			$query="SELECT * FROM `friend_requests` WHERE `sending`=? AND `receiving`=?";
			$com=$db->prepare($query);
			$com->execute(array($sending,$receiving));
			$ccount=$com->rowCount();
			$this->check=($ccount>0)?true:false;
		}
	}
	class acceptFriendRequest {
		function __construct($user,$sender) {
			global $db;
			$query="INSERT INTO `friends`(`user_id`, `friend_id`) VALUES (?,?)";
			$dd =$db->prepare($query);
			$dd->execute(array($sender,$user));
		}
	}
	class insertFollow {
		function __construct($following,$followed) {
			global $db;
			$query="INSERT INTO `follow_info`(`user_id`, `followed_id`) VALUES (?,?)";
			$dd =$db->prepare($query);
			$dd->execute(array($following,$followed));
		}
	}
	class deleteFollow {
		function __construct($following,$followed) {
			global $db;
			$query="DELETE FROM `follow_info` WHERE `user_id`=? AND `followed_id`=?";
			$dd =$db->prepare($query);
			$dd->execute(array($following,$followed));
		}
	}
	class checkFollow {
		public $check;
		function __construct($following,$followed) {
			global $db;
			$query="SELECT * FROM `follow_info` WHERE `user_id`=? AND `followed_id`=?";
			$com=$db->prepare($query);
			$com->execute(array($following,$followed));
			$ccount=$com->rowCount();
			$this->check=($ccount>0)?true:false;
		}
	}
	class selectFriends {
		public $array;
		function __construct($fuser) {
			global $db;
			$query="SELECT * FROM `friends` WHERE `user_id`=? OR `friend_id`=?";
			$com=$db->prepare($query);
			$com->execute(array($fuser,$fuser));
			$this->array=$com->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class selectFollowing {
		public $array;
		function __construct($following) {
			global $db;
			$query="SELECT * FROM `follow_info` WHERE `user_id`=?";
			$com=$db->prepare($query);
			$com->execute(array($following));
			$this->array=$com->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	class selectFriendRequests {
		public $array;
		function __construct($fuser) {
			global $db;
			$query="SELECT * FROM `friend_requests` WHERE `receiving`=?";
			$com=$db->prepare($query);
			$com->execute(array($fuser));
			$this->array=$com->fetchAll(PDO::FETCH_ASSOC);
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
	class checkIfPostExists{
		public $bool;
		function __construct($uid,$name) {
			global $db;
			$query = "SELECT post_id FROM `posts` WHERE user_id=? AND post_id=?";
			$e=$db->prepare($query);
			$e->execute(array($uid,$name));
			$exis=$e->rowCount();
			$this->bool=($exis==1)?true:FALSE;
		}
	}
	class checkIfCommentExists{
		public $bool;
		function __construct($uid,$pid,$cid) {
			global $db;
			$query = "SELECT comment_id FROM `comments` WHERE user_id=? AND post_id=? AND comment_id=?";
			$e=$db->prepare($query);
			$e->execute(array($uid,$pid,$cid));
			$exis=$e->rowCount();
			$this->bool=($exis==1)?true:FALSE;
		}
	}
	class deleteUserPost {
		
		function __construct($uid,$name) {
			global $db;
			$query2="DELETE FROM `posts` WHERE user_id=? AND post_id=?";
			$d=$db->prepare($query2);
			$d->execute(array($uid,$name));
		}
	}
	class deleteUserComment {
		
		function __construct($uid,$pid,$cid) {
			global $db;
			$query2="DELETE FROM `comments` WHERE user_id=? AND post_id=? AND comment_id=?";
			$d=$db->prepare($query2);
			$d->execute(array($uid,$pid,$cid));
		}
	}
	class deleteAllComments {
		
		function __construct($pid) {
			global $db;
			$query2="DELETE FROM `comments` WHERE post_id=?";
			$d=$db->prepare($query2);
			$d->execute(array($pid));
		}
	}
	class updateProfilePicture {
		
		function __construct($picture,$uid) {
			global $db;
			$query ="UPDATE `users` SET `profile_picture`=? WHERE `id`=?";
			$d=$db->prepare($query);
			$d->execute(array($picture,$uid));
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
	class autoUsernameGenerator {
		public $username;
		function __construct($username) {
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
			$this->username=$username;
		}
	}
	class latestUserId {
		public $id;
		function __construct() {
			global $db;
			$idquery="SELECT id FROM `users` ORDER BY id DESC";
			$idd=$db->prepare($idquery);
			$idd->execute();
			$idc= $idd->fetch(PDO::FETCH_ASSOC);
			$this->id = $idc['id'] +1;
		}
	}
	class createNewUser {
		function __construct($id,$username,$name,$password,$birth) {
			global $db;
			global $web;
			$query2="INSERT INTO `users`(`id`,`username`, `name`, `password`, `birth`,`profile`) VALUES (?,?,?,?,?,?)";
			$st =$db->prepare($query2);
			$st->execute(array($id,$username,$name,$password,$birth,$web."profiles/".$username."/posts"));
		}
	}
	class createNewWall {
		function __construct($username) {
			global $db;
			$query="CREATE table ".$username."_wall(placement INT( 15 ) NOT NULL, id INT( 15 ) NOT NULL);";
			$db->exec($query);
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