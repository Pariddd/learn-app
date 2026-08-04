<?php if ($pager->getPageCount() > 1): ?>
    <nav aria-label="Pagination">
        <ul style="display:flex;gap:6px;list-style:none;padding:0;margin:0;align-items:center;justify-content:center;flex-wrap:wrap;">

            <?php if ($pager->hasPreviousPage()): ?>
                <li><a href="<?= $pager->getPreviousPage() ?>" class="cl-btn btn-outline cl-btn-sm">← Sebelumnya</a></li>
            <?php else: ?>
                <li><span class="cl-btn btn-outline cl-btn-sm" style="opacity:.35;pointer-events:none;">← Sebelumnya</span></li>
            <?php endif; ?>

            <?php foreach ($pager->links() as $link): ?>
                <li>
                    <a href="<?= $link['uri'] ?>"
                        class="cl-btn cl-btn-sm <?= $link['active'] ? 'cl-btn-primary' : 'btn-outline' ?>"
                        style="min-width:38px;text-align:center;">
                        <?= esc($link['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <?php if ($pager->hasNextPage()): ?>
                <li><a href="<?= $pager->getNextPage() ?>" class="cl-btn btn-outline cl-btn-sm">Selanjutnya →</a></li>
            <?php else: ?>
                <li><span class="cl-btn btn-outline cl-btn-sm" style="opacity:.35;pointer-events:none;">Selanjutnya →</span></li>
            <?php endif; ?>

        </ul>
    </nav>
<?php endif; ?>