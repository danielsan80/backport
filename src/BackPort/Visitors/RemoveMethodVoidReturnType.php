<?php

namespace BackPort\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class RemoveMethodVoidReturnType extends NodeVisitorAbstract
{
    public function leaveNode(Node $node) {
        if (!$node instanceof Node\Stmt\ClassMethod) {
            return;
        }
        if (!$node->returnType instanceof Node\Identifier) {
            return;
        }
        if ($node->returnType->name!=='void') {
            return;
        }
        $node->returnType = null;
    }

}