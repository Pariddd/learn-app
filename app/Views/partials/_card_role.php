<?php
/**
 * Partial: card role. Pemakaian:
 * <?= view('partials/_card_role', ['role' => $role]) ?>
 * $role wajib: ->nama_role, ->deskripsi, ->thumbnail
 * $role opsional: ->match_percentage
 */
?>
<div class="cl-card" style="overflow:hidden;">
    <img src="<?= base_url('uploads/roles/' . esc($role->thumbnail ?? 'default-role.png')) ?>"
         style="width:100%;height:150px;object-fit:cover;display:block;" alt="<?= esc($role->nama_role) ?>">
    <div class="card-pad">
        <h4 style="font-size:1.05rem;"><?= esc($role->nama_role) ?></h4>
        <p class="cl-text-muted cl-small" style="margin-bottom:10px;"><?= esc(mb_strimwidth($role->deskripsi ?? '', 0, 90, '...')) ?></p>
        <?php if (!empty($role->match_percentage)): ?>
            <?= view('partials/_badge_match', ['percentage' => $role->match_percentage]) ?>
        <?php endif; ?>
    </div>
</div>
