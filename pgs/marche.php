<?php 
	if (!empty($_REQUEST['del'])) : 
		$marca=R::load('marche', intval($_REQUEST['del']));
		try{
			R::trash($marca);
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;	
	if (!empty($_POST['marca'])) : 
		if (empty($_POST['id'])){
			$marca=R::dispense('marche');
		}else{
			$marca=R::load('marche',intval($_POST['id']));
		}
		$marca->marca=$_POST['marca'];

		try {
			$id=R::store($marca);
		} catch (RedBeanPHP\RedException\SQL $e) {
			?>
			<h4 class="msg label error">
				<?=$e->getMessage()?>
			</h4>
			<?
		}	
	endif;
	
	$marche=R::findAll('marche');
?>
<h1>
	<a href="index.php">
		Marche
	</a>
	
</h1>
<section class="">
	<?php foreach ($marche as $ma) : ?>
		<article class="">
                    <form method="post" action="?p=marche" class="col-md-9">
                            <div class="form-group">
                                <input name="marca"  value="<?=$ma->marca?>" class="input-group-sm"/>
                                <input type="hidden" name="id" value="<?=$ma->id?>" class="input-group-sm"/>
                                <button type="submit" tabindex="-1" class="btn-success">
					Salva
				</button>
                                <button class="btn-danger">
                                    <a href="?p=marche&del=<?=$ma['id']?>" class="button dangerous" tabindex="-1">
                                            Elimina
                                    </a>
                                </button>    
                            </div>
			</form>
		</article>
	<?php endforeach; ?>
		<article class="card cc">
                    <form method="post" action="?p=marche" class="col">
                            <div class="form-group">
                                <h2>Inserimento marca</h2>
                                <p>Inserisci la nuova marca del PC!</p>
                                <input name="marca" placeholder="Nuova marca" autofocus class="input-group-sm" />
                                <button type="submit" class="btn-default">
					Inserisci
				</button>
                            </div>
			</form>
		</article>
</section>