<?php  

require_once(__DIR__.'/../model/article_model.php');

class ArticlesadminController {
	public static function articlesadminPage () {
			$article = null;
			if(isset($_GET['id'])) {
			$article= Article::getArticle((int) $_GET['id']);
			}

			if ($article==null) {
			$article= new Article();

			}
			if(isset($_POST['submit'])) {
			$article->setId($_POST['id']);
			$article->setAuteur(htmlspecialchars($_POST['addauthor']));
			$article->setContenu($_POST['addbillet']);
			$article->setTitre(htmlspecialchars($_POST['addtitle']));
			$article->setDate(date('y-m-d h:i:s'));
			$article->persist();
}
			$template = file_get_contents(__DIR__.'/../view/backend/template-admin.html');
			$view = file_get_contents(__DIR__.'/../view/backend/addarticlesadmin_view.html');
			$loop_content = file_get_contents(__DIR__.'/../view/backend/addarticlesadmin_articles.html');

			$template = str_replace('{CONTENT}', $view, $template);
			$template = str_replace('{TITLE}', "Index", $template);
			$template = str_replace('{ARTICLE_ID}', $article->getId(), $template);
			$template = str_replace('{ARTICLE_TITLE}', $article->getTitre(), $template);
			$template = str_replace('{ARTICLE_AUTHOR}', $article->getAuteur(), $template);
			$template = str_replace('{ARTICLE_CONTENT}', $article->getContenu(), $template);
			
			print($template);
	}
}

ArticlesadminController::articlesadminPage();