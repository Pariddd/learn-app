<?php
/**
 * Partial: progress bar. Pemakaian:
 * <?= view('partials/_progress_bar', ['percentage' => $percentage]) ?>
 */
$percentage = max(0, min(100, (float) ($percentage ?? 0)));
?>
<div style="background:var(--blue-50); border-radius:999px; height:8px; overflow:hidden;">
    <div style="width:<?= esc($percentage, 'attr') ?>%; height:100%; background:var(--blue-500); border-radius:999px;"></div>
</div>
<span class="cl-small cl-text-muted"><?= esc(number_format($percentage, 1)) ?>%</span>
