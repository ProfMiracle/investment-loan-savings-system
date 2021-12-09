<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class Pagination extends Controller
{
    private $___currentpage = '';
    private $url;
    private $valid;
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
        $this->___currentpage = $request->page??1;
        $this->url = $request->url();
        $this->valid = true;
    }

    private function lessthan1()
    {
        return sprintf("<nav>
                    <ul class=\"pagination\">

                        <li class=\"page-item disabled\" aria-disabled=\"true\" aria-label=\"« Previous\">
                            <span class=\"page-link\" aria-hidden=\"true\">‹</span>
                        </li>
                        <li class=\"page-item active\" aria-current=\"page\"><span class=\"page-link\">%s</span></li>
                        <li class=\"page-item\"><a class=\"page-link\" href=\"%s\">%s</a></li>
                        <li class=\"page-item\">
                            <a class=\"page-link\" href=\"%s\" rel=\"next\" aria-label=\"Next »\">›</a>
                        </li>
                    </ul>
                </nav>",
        $this->___currentpage,
        $this->url."?page=".((int)$this->___currentpage+1),
        (int)$this->___currentpage + 1,
        $this->url."?page=".((int)$this->___currentpage + 1)
        );
    }

    public function view()
    {
        if ($this->valid)
        {
            if ($this->request->page <= 1)
            {
                return $this->lessthan1();
            }
            return $this->morethan1();
        }
    }

    private function morethan1()
    {
        return sprintf("<nav>
            <ul class=\"pagination\">
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"%s\" rel=\"prev\" aria-label=\"« Previous\">‹</a>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"%s\">%s</a>
                </li>
                <li class=\"page-item active\" aria-current=\"page\">
                    <span class=\"page-link\">%s</span>
                </li>
                <li class=\"page-item\">
                    <a class=\"page-link\" href=\"%s\" rel=\"next\" aria-label=\"Next »\">›</a>
                </li>
            </ul>
        </nav>",
            $this->url."?page=".((int)$this->___currentpage-1),
            $this->url."?page=".((int)$this->___currentpage-1),
            (int)$this->___currentpage - 1,
            (int)$this->___currentpage + 1,
            $this->url."?page=".((int)$this->___currentpage+1)
        );
    }
}
