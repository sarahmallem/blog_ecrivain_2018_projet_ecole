<?php  
require_once(__DIR__.'/../model/article_model.php');
require_once(__DIR__.'/../model/comments_model.php');

class reportController {
	public static function reportadminPage () {	
			if(isset($_POST['deletereport'])) {
			$deletereport= Comment::getCommentdb($_POST['commentId']);
			$deletereport->deletecomment();
	}
			if(isset($_POST['canceldelete'])) {
			$cancelreport= Comment::getCommentdb($_POST['commentId']);
			$cancelreport->cancelcomment();
			}

			$template = file_get_contents(__DIR__.'/../view/backend/template-admin.html');
			$view = file_get_contents(__DIR__.'/../view/backend/reportadmin_view.html');
			$loop_content = file_get_contents(__DIR__.'/../view/backend/reportadmin_articles.html');
			$loop_report = file_get_contents(__DIR__.'/../view/backend/reportadmin_listreport.html');
			$articles = Article::getArticles();


		$articleListe = "";
		foreach ($articles as $article) {
			$articleListe.=  str_replace('{ARTICLE_TITLE}', $article->getTitre(), $loop_content);
			$articleListe =  str_replace('{ARTICLE_DATE}', $article->getDate(), $articleListe);
			$articleListe =  str_replace('{ARTICLE_CONTENT}', $article->getContenu(), $articleListe);

			
			$comments = Comment::getReportCommentss($article->getId());
			$list_report = "";
 		foreach ($comments as $comment) {
 			$currentComment = $loop_report;
			$currentComment =  str_replace('{COMMENTS_AUTHOR}', $comment->getAuthor(), $currentComment);
			$currentComment =  str_replace('{COMMENTS_DATE}', $comment->getComment_Date(), $currentComment);
			$currentComment =  str_replace('{COMMENTS_COMMENT}',$comment->getComment(), $currentComment);
			$currentComment = str_replace('{COMMENTS_ID}', $comment->getid(), $currentComment);
			$currentComment = str_replace('{COMMENTS_REPORT}', $comment->getReportComment(), $currentComment);
			$list_report .= $currentComment;
		}
		$articleListe =  str_replace('{LOOP_LISTREPORT}', $list_report, $articleListe); 
		}
			$view = str_replace('{BOUCLE}', $articleListe, $view);
			$template = str_replace('{CONTENT}', $view, $template);
			$template = str_replace('{TITLE}', "Index", $template);
			
			print($template);
	}
}

reportController::reportadminPage();