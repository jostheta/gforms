<div class="page_layout">
    <h1>Your Forms</h1>
    <table>
        <thead>
            <tr>
                <th>Form Title</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($forms)) : ?>
                <?php foreach ($forms as $form) : ?>
                    <tr>
                        <td><a href="<?= base_url('forms/list_form_responses/' . $form->form_id) ?>"><?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?></a></td>
                        <td><?= date('Y-m-d H:i:s', strtotime($form->created_at)) ?></td>
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
