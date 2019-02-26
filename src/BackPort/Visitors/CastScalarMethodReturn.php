<?php

namespace BackPort\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class CastScalarMethodReturn extends NodeVisitorAbstract
{

    protected $map = [
        'string' => Node\Expr\Cast\String_::class,
        'bool' => Node\Expr\Cast\Bool_::class,
        'int' => Node\Expr\Cast\Int_::class,
        'float' => Node\Expr\Cast\Double::class,
    ];
    public function leaveNode(Node $node) {
        if (!$node instanceof Node\Stmt\ClassMethod) {
            return;
        }
        if (!$node->name instanceof Node\Identifier) {
            return;
        }
        if (!$node->returnType instanceof Node\Identifier) {
            return;
        }
        if (!in_array($node->returnType->name, array_keys($this->map))) {
            return;
        }
        if (!is_array($node->stmts)) {
            return;
        }

        foreach ($node->stmts as $i => $stmt) {
            if (!$stmt instanceof Node\Stmt\Return_) {
                continue;
            }
            if (in_array(get_class($stmt->expr), $this->map)) {
                continue;
            }

            $castClass = $this->map[$node->returnType->name];

            $node->stmts[$i]->expr = new $castClass($node->stmts[$i]->expr);
        }
    }

}