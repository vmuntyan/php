$(document).ready(function() {
    loadTree();

    $('#create-root').on('click', function() {
        $.post('php/nodes.php', { action: 'create_root' }, function(response) {
            const root = JSON.parse(response);
            $('#tree-container').append(createNodeElement(root.id, 'root'));
        });
    });

    $(document).on('click', '.add-node', function() {
        const parentId = $(this).closest('.node').data('id');
        $.post('php/nodes.php', { action: 'add_node', parent_id: parentId }, function(response) {
            const node = JSON.parse(response);
            const newNode = createNodeElement(node.id, 'node');
            $(`[data-id=${parentId}]`).append(newNode);
        });
    });

    $(document).on('click', '.delete-node', function() {
        const nodeId = $(this).closest('.node').data('id');
        $('#popup-message').text('Are you sure you want to delete this node?');
        $('#confirmation-popup').modal('show').data('id', nodeId);
        startCountdown(20);
    });

    $('#confirm-delete, #cancel-delete').on('click', function() {
        stopCountdown();
    });

    $(document).on('click', '.edit-node', function() {
        const nodeId = $(this).closest('.node').data('id');
        const node = $(`[data-id=${nodeId}]`);
        const label = node.find('.node-label');
        const editor = node.find('.node-editor');

        label.hide();
        editor.show().find('input').focus().val(label.text());
    });

    $(document).on('click', '.save-edit', function() {
        const nodeId = $(this).closest('.node').data('id');
        const editor = $(this).closest('.node-editor');
        const newName = editor.find('input').val();
        const label = editor.siblings('.node-label');

        if (newName !== '') {
            $.post('php/nodes.php', { action: 'edit_node', id: nodeId, name: newName }, function() {
                label.text(newName);
            });
        }

        editor.hide();
        label.show();
    });

    $(document).on('click', '.cancel-edit', function() {
        const editor = $(this).closest('.node-editor');
        const label = editor.siblings('.node-label');

        editor.hide();
        label.show();
    });

    $(document).on('click', '.expand-node', function() {
        const node = $(this).closest('.node');
        const children = node.children('.children');
        const isExpanded = children.is(':visible');
        children.toggle(!isExpanded);
        $(this).toggleClass('expanded', !isExpanded);
        $(this).html(isExpanded ? '►' : '▼');

    });

    function createNodeElement(id, name, hasChildren, expanded) {
        return `<div class="node" data-id="${id}">
                    ${hasChildren ? `<span class="actions">
                        <button class="expand-node btn btn-secondary ${expanded ? 'expanded' : ''}">${expanded ? '▼' : '►'}</button>
                    </span>` : ''}
                    <span class="node-label">${name}</span>
                    <span class="node-editor">
                        <input type="text" class="form-control" value="${name}" />
                        <button class="save-edit btn btn-primary">Save</button>
                        <button class="cancel-edit btn btn-secondary">Cancel</button>
                    </span>
                    <span class="actions">
                        <button class="add-node btn btn-success">+</button>
                        <button class="delete-node btn btn-danger">-</button>
                        <button class="edit-node btn btn-info">Edit</button>
                    </span>
                    <div class="children"></div>
                </div>`;
    }
    

    function loadTree() {
        $.post('php/nodes.php', { action: 'get_nodes' }, function(response) {
            const nodes = JSON.parse(response);
            const nodesById = {};
            nodes.forEach(node => {
                nodesById[node.id] = node;
            });
    
            const buildTree = (parentId, container) => {
                nodes.filter(node => node.parent_id == parentId).forEach(node => {
                    const nodeElement = createNodeElement(node.id, node.name, node.has_children, node.expanded);
                    container.append(nodeElement);
                    if (node.has_children && node.expanded) {
                        buildTree(node.id, $(`[data-id=${node.id}] .children`));
                    }
                });
            };
    
            buildTree(null, $('#tree-container'));
            updateExpandButtons();
        });
    }

    function startCountdown(seconds) {
        let timer = seconds;
        $('#popup-timer').text(`Time Left: ${timer}s`);
        const interval = setInterval(function() {
            timer--;
            $('#popup-timer').text(`Time Left: ${timer}s`);
            if (timer <= 0) {
                clearInterval(interval);
                $('#confirmation-popup').modal('hide');
            }
        }, 1000);
    }

    function stopCountdown() {
        $('#popup-timer').text('');
        clearInterval(interval);
    }
});
