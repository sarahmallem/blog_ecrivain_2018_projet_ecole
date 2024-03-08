<?php  

require_once(__DIR__.'/../model/article_model.php');
require_once(__DIR__.'/../model/comments_model.php');

class HomeController {

	public static function homePage () {
		
		$template = file_get_contents(__DIR__.'/../view/frontend/template.html');
		$view = file_get_contents(__DIR__.'/../view/frontend/home_view.html');
		$loop_content = file_get_contents(__DIR__.'/../view/frontend/home_article.html');
		$articles = Article::getArticles();


		$articleListe = "";
		foreach ($articles as $article) {
			$articleListe.=  str_replace('{ARTICLE_TITLE}', $article->getTitre(), $loop_content);
			$articleListe =  str_replace('{ARTICLE_DATE}', $article->getDate(), $articleListe);
			$articleListe =  str_replace('{ARTICLE_CONTENT}', $article->getContenu(), $articleListe);

			$comments = Comment::getComments($article->getId());
		foreach ($comments as $comment) {
			$articleListe =  str_replace('{COMMENTS_AUTHOR}', $comment->getAuthor(), $articleListe);
			$articleListe =  str_replace('{COMMENTS_DATE}', $comment->getComment_Date(), $articleListe);
			$articleListe =  str_replace('{COMMENTS_COMMENT}',$comment->getComment(), $articleListe);
		}
		}	
		

		$view = str_replace('{BOUCLE}', $articleListe, $view);
		$template = str_replace('{CONTENT}', $view, $template);
		$template = str_replace('{TITLE}', "Index", $template);
		
		print($template);
	}

}

HomeController::homePage();

 

