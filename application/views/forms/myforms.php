<div style="margin: 0 10%;">
<h1>My Forms</h1>

    <table>
        <thead>
            <tr>
                <th>Form Title</th>
                <th>Published</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($forms)) : ?>
                <?php foreach ($forms as $form) : ?>
                    <tr>
                    <td>
                        <a href="<?= base_url() ?>forms/preview/<?=$form->form_id?>">
                        <?= htmlspecialchars($form->title ? $form->title : $form->form_id, ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </td>
                        <td><?= ($form->is_published == 0)?'No':'Yes'?></td>
                        <td><?php echo date('Y-m-d H:i:s', strtotime($form->created_at)); ?></td>
                        <td><a href="<?= base_url() ?>forms/delete/<?= $form->form_id ?>" onclick="return confirm('Are you sure you want to delete this form?');">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="2">No forms found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
            </div>