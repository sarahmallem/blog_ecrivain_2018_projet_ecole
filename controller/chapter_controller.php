<?php  

require_once(__DIR__.'/../model/article_model.php');
require_once(__DIR__.'/../model/comments_model.php');

class ChapterController {

	public static function chapterPage () {
		if(isset($_POST['report'])) {
		$report= Comment::getCommentdb($_POST['commentId']);
		$report->setReportcomment(true);
		$report->persist(); 
		}	

		if(isset($_POST['submit'])) {
			$comment= new Comment();
			$comment->setPost_id($_POST['postId']);
			$comment->setComment($_POST['message']);
			$comment->setAuthor(htmlspecialchars($_POST['author']));
			$comment->setComment_date(date('y-m-d h:i:s'));
			$comment->persist();
		}
		$template = file_get_contents(__DIR__.'/../view/frontend/template.html');
		$view = file_get_contents(__DIR__.'/../view/frontend/chapter_view.html');
		$loop_content = file_get_contents(__DIR__.'/../view/frontend/chapter_articles.html');
		$loop_comment = file_get_contents(__DIR__.'/../view/frontend/chapter_comment.html');
		$articles = Article::getArticles();

		$articleListe = "";
		foreach ($articles as $article) {
			$articleListe.=  str_replace('{ARTICLE_TITLE}', $article->getTitre(), $loop_content);
			$articleListe =  str_replace('{ARTICLE_DATE}', $article->getDate(), $articleListe);
			$articleListe =  str_replace('{ARTICLE_CONTENT}', $article->getContenu(), $articleListe);
			$articleListe =  str_replace('{ARTICLE_AUTEUR}', $article->getAuteur(), $articleListe);
			$articleListe =  str_replace('{ARTICLE_ID}', $article->getId(), $articleListe);

			$comments = Comment::getComments($article->getId());
			$comments_content = "";
		foreach ($comments as $comment) {
			$currentComment = $loop_comment;
			$currentComment =  str_replace('{COMMENTS_AUTHOR}', $comment->getAuthor(), $currentComment);
			$currentComment =  str_replace('{COMMENTS_DATE}', $comment->getComment_Date(), $currentComment);
			$currentComment =  str_replace('{COMMENTS_COMMENT}',$comment->getComment(), $currentComment);
			$currentComment = str_replace('{COMMENTS_ID}', $comment->getid(), $currentComment);
			$comments_content .= $currentComment;
		}
		$articleListe =  str_replace('{LOOP_COMMENTS}', $comments_content, $articleListe); 
		}
			
		

		$view = str_replace('{BOUCLE}', $articleListe, $view);
		$template = str_replace('{CONTENT}', $view, $template);
		$template = str_replace('{TITLE}', "Index", $template);
		
		print($template);
	}

}

ChapterController::chapterPage();