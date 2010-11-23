<?php
  $row = array();
  foreach ($rows as $col){
    foreach ($col as $ltr => $value){
      $row[$ltr][] = $value;
    }
  }
  $first = TRUE;
  $element = 'odd';
?>
<table class="<?php print $class; ?>">
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>

  <?php if ($first):?>
  <thead>
    <tr class="<? echo $element; ?>">
      <th>
      </th>
      <?php foreach($row['title'] as $title): ?>
      <th>
      <?php echo $title; ?>
      </th>
      <?php endforeach; ?>
    </tr>
</thead>
<?php  $first = FALSE;
        endif; //$first
        $element = 'even';
  if (!$first): ?>
  <tbody>
    <?php foreach ($row as $cck_field => $rowname):?>
      <?php if ($cck_field != title): ?>
      <tr class="<? echo $element; ?>">
        <th>
          <?php echo $header[$cck_field]; ?>
        </th>
    <?php foreach($rowname as $count => $item): ?>
        <td>
          <?php echo $item; ?>
        </td>
      <?php endforeach; ?>
      </tr>
      <?php
          if ($element == 'odd'){
      $element = 'even';
    } else {
      $element = 'odd';
    }
     endif; //cck_field != title
  endforeach; ?>
  </tbody>
<?php endif; //!first ?>
</table>