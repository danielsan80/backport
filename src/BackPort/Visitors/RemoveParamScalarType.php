<?php

namespace BackPort\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class RemoveParamScalarType extends NodeVisitorAbstract
{
    public function leaveNode(Node $node) {
        if (!$node instanceof Node\Param) {
            return;
        }
        if (!$node->type instanceof Node\Identifier) {
            return;
        }
        if (!in_array($node->type->name, ['string', 'bool', 'int', 'callable', 'array', 'float'])) {
            return;
        }
        $node->type = null;
    }

}