<?php

namespace BackPort\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class RemoveParamNullableType extends NodeVisitorAbstract
{
    public function leaveNode(Node $node) {
        if (!$node instanceof Node\Param) {
            return;
        }
        if (!$node->type instanceof Node\NullableType) {
            return;
        }
        $node->type = $node->type->type;
        $node->default = new Node\Expr\ConstFetch(new Node\Name(['null']));
    }

}