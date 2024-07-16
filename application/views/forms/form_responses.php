<div class="page_layout">
    <h1>Responses for: <?= htmlspecialchars($form->title, ENT_QUOTES, 'UTF-8') ?></h1>
    <table>
        <thead>
            <tr>
                <th>Response ID</th>
                <th>Submitted At</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($responses)) : ?>
                <?php foreach ($responses as $response) : ?>
                    <tr>
                        <td><a href="<?= base_url('forms/view_response/' . $response->response_id) ?>"><?= $response->response_id ?></a></td>
                        <td><?= date('Y-m-d H:i:s', strtotime($response->created_at)) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="2">No responses found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
