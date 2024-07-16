<div style="margin: 0 10%;">
    <h1>My Drafts</h1>

    <table>
        <thead>
            <tr>
                <th>Draft Title</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($forms)) : ?>
                <?php foreach ($forms as $form) : ?>
                    <?php if ($form->is_published == 0) : ?>
                        <tr>
                            <td><a href="<?= base_url() ?>forms/view_form/<?= $form->form_id ?>"><?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?></a></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($form->created_at)); ?></td>
                            <td><a href="<?= base_url() ?>forms/delete/<?= $form->form_id ?>" onclick="return confirm('Are you sure you want to delete this form?');">Delete</a></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3">No Drafts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
