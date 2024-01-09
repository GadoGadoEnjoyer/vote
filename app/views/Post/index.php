<!DOCTYPE html>
<html>
<head>
    <title>Vote</title>
    <link rel="stylesheet" href="<?php echo BASEURL ?>/public/css/style.css">
</head>
<body>
    <h1><?php echo($data['posts']['title'])?></h1>
    <h3><?php echo($data['posts']['body'])?></h3>
    <hr>
    <form action="" method="POST">
        <?php foreach($data['options'] as $option) :?>
            <?php if($data['voted']) :?>
                <?php if(isset($data['img'][$option['id']])) :?>
                    <img src="<?php echo(BASEURL.'/public/assets/'.$data['img'][$option['id']]['image']) ?>">
                <?php endif ?>
                <br>
                <input disabled type="radio" name="option" value="<?php echo($option['id']) ?>"><?php echo($option['option_name'])?></option>
                <br>
                <h2><?php echo("Total Vote : ".$option['value'])?></h2>
            <?php else :?>
                <?php if(isset($data['img'][$option['id']])) :?>
                    <img src="<?php echo(BASEURL.'/public/assets/'.$data['img'][$option['id']]['image']) ?>">
                <?php endif ?>
                <br>
                <input type="radio" name="option" value="<?php echo($option['id']) ?>"><?php echo($option['option_name'])?></option>
                <br>
                <h2><?php echo("Total Vote : ".$option['value'])?></h2>
                <?php endif ?>  
        <?php endforeach ?>
        <br><br>
        <input type="submit" value="Vote">
    </form>
    <form action="" method="POST">
        <textarea name="comment"></textarea>
        <input type="submit" value="Comment">   
    </form>
    <?php foreach($data['comments'] as $comment) :?>
        <h5><?php echo($comment['username'])?></h5><h2><?php echo($comment['comment'])?></h2>
    <?php endforeach ?>
    <hr>
    <h2>Share your page!</h2><br><h2><?php echo BASEURL.'/'.$_GET['url'] ?></h2>
    <a href="<?php echo BASEURL ?>">Home</a>
</body>
</html>
