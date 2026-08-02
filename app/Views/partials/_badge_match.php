<?php
/**
 * Partial: badge match percentage. Pemakaian:
 * <?= view('partials/_badge_match', ['percentage' => $percentage]) ?>
 */
?>
<span class="cl-badge badge-blue">Match <?= esc(number_format((float) $percentage, 0)) ?>%</span>
