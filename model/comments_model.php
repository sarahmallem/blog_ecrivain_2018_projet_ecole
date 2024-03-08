<?php 

class Comment { 

	private $id = null;
	private $post_id;
	private $author;
	private $comment;
	private $comment_date;
	private $reportcomment;

	public function getId(){
		return $this->id;
	}

	public function getPost_id(){
		return $this->post_id;
	}

	public function setPost_id($post_id){
		$this->post_id = $post_id;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function getComment(){
		return $this->comment;
	}

	public function setComment($comment){
		$this->comment = $comment;
	}

	public function getComment_date(){
		return $this->comment_date;
	}

	public function setComment_date($comment_date){
		$this->comment_date = $comment_date;
	}

	public function getReportcomment(){
		return $this->reportcomment;
	}

	public function setReportcomment($reportcomment){
		$this->reportcomment = $reportcomment;
	}


	public function persist(){
		if($this->id==null) {
			$this->insert();
		} else {
			$this->update();
		}
	}

	private function insert(){
		$bdd = Database::getDb();
		$query = "INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?,?,?,?)";
		$stmt = $bdd->prepare($query); 
		$stmt->execute([
			$this->post_id, 
			$this->author,
			$this->comment,
			$this->comment_date,
		]);
		$this->id=$bdd->lastInsertId();
		return true;
	}

	public function update() {
			$bdd = Database::getDb();
			$query = "UPDATE comments SET post_id = ?, author = ? , comment = ?, comment_date = ?, reportcomment = ? WHERE id = ?";
			$stmt = $bdd->prepare($query);
			$stmt->execute([
				$this->post_id,
				$this->author,
				$this->comment,
				$this->comment_date,
				$this->reportcomment,
				$this->id
			]);
			return true;
}
	public static function getCommentdb($commentId) {
		$bdd = Database::getDb(); 
		$reponse = $bdd->query('SELECT * FROM comments WHERE id = "'.$commentId.'"');

		$result= array();
		while ($donnees = $reponse->fetch())
		{
			$currentComment= new Comment();
			$currentComment->id = $donnees['id'];
			$currentComment->setPost_id($donnees['post_id']);
			$currentComment->setAuthor($donnees['author']);
			$currentComment->setComment($donnees['comment']);
			$currentComment->setComment_date($donnees['comment_date']);
			$currentComment->setReportcomment($donnees['reportcomment'] == "1");

			return $currentComment;
		}
		return null;

	}

	public static function getComments($id_post) {

		$bdd = Database::getDb(); 
		$reponse = $bdd->query('SELECT * FROM comments WHERE post_id = "'.$id_post.'"');

		$result= array();
		while ($donnees = $reponse->fetch())
		{
			$currentComment= new Comment();
			$currentComment->id = $donnees['id'];
			$currentComment->setPost_id($donnees['post_id']);
			$currentComment->setAuthor($donnees['author']);
			$currentComment->setComment($donnees['comment']);
			$currentComment->setComment_date($donnees['comment_date']);
			$currentComment->setReportcomment($donnees['reportcomment'] == "1");

			array_push($result, $currentComment);
		}
		return $result; 
	}

	public static function getReportcommentss($id_post) {

		$bdd = Database::getDb(); 
		$reponse = $bdd->query('SELECT * FROM comments WHERE reportcomment = 1 AND post_id = "'.$id_post.'"');

		$result= array();
		while ($donnees = $reponse->fetch())
		{
		$currentComment= new Comment();
		$currentComment->id = $donnees['id'];
		$currentComment->setPost_id($donnees['post_id']);
		$currentComment->setAuthor($donnees['author']);
		$currentComment->setComment($donnees['comment']);
		$currentComment->setComment_date($donnees['comment_date']);
		$currentComment->setReportcomment($donnees['reportcomment']);

			array_push($result, $currentComment);
		}
		return $result; 
	}

		public function cancelcomment() {
			$bdd = Database::getDb();
			$bdd->query('UPDATE comments SET reportcomment = 0 WHERE id = '.((int) $this->id));
}

	public function deletecomment() {
			$bdd = Database::getDb();
			$bdd->query('DELETE FROM comments WHERE id = '.((int) $this->id));
	}

}


