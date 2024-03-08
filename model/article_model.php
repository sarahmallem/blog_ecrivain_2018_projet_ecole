<?php
class Article { 

	private $id;
	private $titre;
	private $auteur;
	private $date;
	private $contenu;
	private $author;
	private $comments;

	public function getId(){
	return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getTitre(){
		return $this->titre;
	}

	public function setTitre($titre){
		$this->titre = $titre;
	}

	public function getAuteur(){
		return $this->auteur;
	}

	public function setAuteur($auteur){
		$this->auteur = $auteur;
	}

	public function getDate(){
		return $this->date;
	}

	public function setDate($date){
		$this->date = $date;
	}

	public function getContenu(){
		return $this->contenu;
	}

	public function setContenu($contenu){
		$this->contenu = $contenu;
	}

	public function getAuthor(){
		return $this->author;
	}

	public function setAuthor($author){
		$this->author = $author;
	}

	public function getComments(){
		return $this->comments;
	}

	public function setComments($comments){
		$this->comments = $comments;
	}

	public static function getArticles() { 

		$bdd = Database::getDb(); 
		$reponse = $bdd->query('SELECT * FROM articles');

		$result= array();
		while ($donnees = $reponse->fetch())
		{
			$currentArticle= new Article();
			$currentArticle->id=$donnees["id"];
			$currentArticle->titre=$donnees["titre"];
			$currentArticle->auteur=$donnees["auteur"];
			$currentArticle->date=$donnees["date"];
			$currentArticle->contenu=$donnees["contenu"];

			array_push($result, $currentArticle);
		}
		return $result; 
	}


	public static function getArticle(int $id) { 

		$bdd = Database::getDb(); 
		$reponse = $bdd->query('SELECT * FROM articles WHERE id='.$id);

		while ($donnees = $reponse->fetch())
		{
			$currentArticle= new Article();
			$currentArticle->id=$donnees["id"];
			$currentArticle->titre=$donnees["titre"];
			$currentArticle->auteur=$donnees["auteur"];
			$currentArticle->date=$donnees["date"];
			$currentArticle->contenu=$donnees["contenu"];
			return $currentArticle;
		}
		return null; 
	}

public function persist() {
	if($this->id!=null) {
	$this->update();
	} else {
	$this->insert();
	}
}

public function insert() {
			$bdd = Database::getDb();
			$query = "INSERT INTO articles (titre, auteur, date, contenu) VALUES (?,?,?,?)";
			$stmt = $bdd->prepare($query);
			$stmt->execute([
				$this->titre,
				$this->auteur,
				$this->date,
				$this->contenu
			]);
			$this->id=$bdd->lastInsertId();
			return true;

}

public function update() {
			$bdd = Database::getDb();
			$query = "UPDATE articles SET titre = ? , auteur = ?, contenu = ?, date = CURDATE() WHERE id = ?";
			$stmt = $bdd->prepare($query);
			$stmt->execute([
				$this->titre,
				$this->auteur,
				$this->contenu,
				$this->id
			]);
			return true;
}

public function delete() {
			$bdd = Database::getDb();
			$bdd->query('DELETE FROM articles WHERE id = '.((int) $this->id));
	}
}

?>

