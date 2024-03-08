<?php  
require_once(__DIR__.'/../model/article_model.php');
require_once(__DIR__.'/../model/comments_model.php');

class CommentsController {

	public static function commentsPage () {
			if(isset($_POST['deletecomments'])) {
			$deletecomments= Comment::getCommentdb($_POST['commentId']);
			$deletecomments->deletecomment();
	}
		$template = file_get_contents(__DIR__.'/../view/backend/template-admin.html');
		$view = file_get_contents(__DIR__.'/../view/backend/commentsadmin_view.html');
		$loop_content = file_get_contents(__DIR__.'/../view/backend/commentsadmin_articles.html');
		$loop_comment = file_get_contents(__DIR__.'/../view/backend/commentsadmin_listcomment.html');
		$articles = Article::getArticles();


		$articleListe = "";
		foreach ($articles as $article) {
			$articleListe.=  str_replace('{ARTICLE_TITLE}', $article->getTitre(), $loop_content);
			$articleListe =  str_replace('{ARTICLE_DATE}', $article->getDate(), $articleListe);
			$articleListe =  str_replace('{ARTICLE_CONTENT}', $article->getContenu(), $articleListe);

			$comments = Comment::getComments($article->getId());
			$list_comment = "";
		foreach ($comments as $comment) {
			$currentComment = $loop_comment;
			$currentComment =  str_replace('{COMMENTS_AUTHOR}', $comment->getAuthor(), $currentComment);
			$currentComment =  str_replace('{COMMENTS_DATE}', $comment->getComment_Date(), $currentComment);
			$currentComment =  str_replace('{COMMENTS_COMMENT}',$comment->getComment(), $currentComment);
			$currentComment = str_replace('{COMMENTS_ID}', $comment->getid(), $currentComment);
			$list_comment .= $currentComment;
		}
		$articleListe =  str_replace('{LOOP_LISTCOMMENT}', $list_comment, $articleListe); 
		}

		$view = str_replace('{BOUCLE}', $articleListe, $view);
		$template = str_replace('{CONTENT}', $view, $template);
		$template = str_replace('{TITLE}', "Index", $template);
		
		print($template);
	}

}

CommentsController::commentsPage();