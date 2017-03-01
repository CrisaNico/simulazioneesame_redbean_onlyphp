<?php
    $msg='';
    $id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
    $computer=(empty($_REQUEST['id'])) ? R::dispense('pc') : R::load('pc', intval($_REQUEST['id']));
    if (!empty($_REQUEST['hostname'])) :
        $computer->hostname=$_POST['hostname'];
        $computer->marche_id=$_POST['marche_id'];
        $computer->modello=$_POST['modello'];
        $computer->sn=$_POST['sn'];
        try {
            R::store($pc);
            $msg='Dati salvati correttamente ('.json_encode($computer).') ';
        } catch (RedBeanPHP\RedException\SQL $e) {
            $msg=$e->getMessage();
        }
    endif;
    
    if (!empty($_REQUEST['del'])) :
        $pc=R::load('pc', intval($_REQUEST['del']));
        try {
            R::trash($computer);
        } catch (RedBeanPHP\RedException\SQL $e) {
            
            $msg=$e->getMessage();
        }
    endif;
    
    $pc = R::findAll('pc', 'ORDER by id ASC LIMIT 999');
    $marche = R::findAll('marche');
    $new=!empty($_REQUEST['create']);
    
    /*-----------------------------------------------------------------------*/
    
    $msg='';
	$id = (!empty($_REQUEST['id'])) ? intval($_REQUEST['id']) : false;
	$intervento=(empty($_REQUEST['id'])) ?  R::dispense('interventi') : R::load('interventi', intval($_REQUEST['id']));
	if (!empty($_REQUEST['descrizione'])) : 
		$intervento->descrizione=$_POST['descrizione'];
		$intervento->pc_id=$_POST['pc_id'];
		$intervento->spesa=floatval($_POST['spesa']);
		$intervento->ore=intval($_POST['ore']);
		$intervento->dataintervento=date_create($_POST['dataintervento']);
		try {
			R::store($intervento);
			$msg='Dati salvati correttamente ('.json_encode($intervento).') ';
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;	
	
	if (!empty($_REQUEST['del'])) : 
		$intervento=R::load('interventi', intval($_REQUEST['del']));
		try{
			R::trash($intervento);
		} catch (RedBeanPHP\RedException\SQL $e) {
			$msg=$e->getMessage();
		}
	endif;
	
	$interventi=R::findAll('interventi', 'ORDER by id ASC LIMIT 999');
	$pc=R::findAll('pc');
	$new=!empty($_REQUEST['create']);
    
?>

<h1>
	<a href="index.php">
		<?=($id) ? ($new) ? 'Nuovo Pc' : 'Pc n. '.$id : 'Pc';?>
	</a>
</h1>

<?php if ($id || $new) : ?>
    <form method="post" action="?p=pc">
        <div class="form-group">
            <?php if ($id) : ?>
            <input type="hidden" name="id" value="<?=$computer->id?>"/>
            <?php endif; ?>
            <label for="hostname">
                Hostname
            </label>
            <input name="hostname" value="<?=$computer->hostname?>" autofocus required />

            <label for="marche_id">
                Marca
            </label>
            <select name="marche_id">
                <option />
                <?php foreach ($marche as $a) : ?>
                    <option value="<?=$a->id?>" <?=($a->id==$id) ? 'selected' :''?> >
                        <?=$a->marca?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="modello">
                Modello
            </label>
            <input name="modello" value="<?=$computer->modello?>" type="text"/>

            <label for="sn">
                Serial Number
            </label>
            <input name="sn" value="<?=$computer->sn?>" type="text"/>
            <button type="submit" tabindex="-1" class="btn-success btn-lg">
                Salva
            </button>
            
            <button class="btn-lg btn-warning">
                <a href="?p=pc">
                    Elenco
                </a>
            </button>
            
            <button class="btn-lg btn-danger">
                <a href="?p=pc&del=<?=$id['id']?>" tabindex="-1">
                    Elimina
                </a>
            </button>
        </div>
    </form>
<?php else : ?>
    <div class="tablecontainer">
        <table style="table-layout:fixed" class="table-bordered">
			<colgroup>
				<col style="width:150px" />
			</colgroup>
			<thead>
				<tr>
					<th>Hostname</th>
					<th>Marca</th>
					<th>Modello</th>
					<th>Serial Number</th>
					<th style="width:60px;text-align:center">Modifica</th>
					<th style="width:60px;text-align:center">Cancella</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($pc as $r) : ?>
				<tr>
                                        <td>
						<?=$r->hostname?>
					</td>
					<td>
							<?=($r->marche_id) ? $r->marche->marca : ''?>
					</td>			
					<td>
						<?=$r->modello?>
					</td>
					<td style="text-align:right" >
						<?=$r->sn?>
					</td>
					<td style="text-align:center" >
                                            <button class="btn-sm btn-warning">
						<a href="?p=pc&id=<?=$r['id']?>">
							Mod.
						</a>
                                            </button>
					</td>
					<td style="text-align:center" >
                                            <button class="btn-sm btn-danger">
						<a href="?p=pc&del=<?=$r['id']?>" tabindex="-1">
							x
						</a>
                                            </button>
					</td>							
				</tr>		
			<?php endforeach; ?>
			</tbody>
		</table>
		<h4 class="msg">
			<?=$msg?>
		</h4>	
	</div>
<?php endif; ?>
<a href="?p=pc&create=1">Inserisci nuovo</a>

<br/>
<br/>

<h1>Tabella interventi</h1>

<input type="date" id="data" onkeyup="filter()" placeholder="Inserisci la data da filtrare"/>

<div class="tablecontainer">
    <table class="table-bordered" id="tabella">
        <thead>
            <tr>
                <th>Hostname</th>
                <th>Data Intervento</th>
                 <th>Spesa</th>
                <th>Ore</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($interventi as $r) : ?>
            <tr>
                <td>
                  <?=($r->pc_id) ? $r->pc->hostname : '' ?>
                </td>
                <td>
                    <?=$r->dataintervento?>
                </td>
                <td>
                    <?=$r->spesa?>
                </td>
                <td>
                    <?=$r->ore?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
	var chg=function(e){
		console.log(e.name,e.value)
		document.forms.frm.elements[e.name].value=(e.value) ? e.value : null
	}
        
        
   function filter() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("data");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabella");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>