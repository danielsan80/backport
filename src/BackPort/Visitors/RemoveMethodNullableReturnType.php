<?php

namespace BackPort\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class RemoveMethodNullableReturnType extends NodeVisitorAbstract
{
    public function leaveNode(Node $node) {
        if (!$node instanceof Node\Stmt\ClassMethod) {
            return;
        }
        if (!$node->returnType instanceof Node\NullableType) {
            return;
        }
        $node->returnType = null;
    }

}