<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

class Pagination
{
    public $total;
    public $instance = [];
    public $template = 'default';
    public $templates = [
        'default' => [
            'base' => '<ul class="pagination m-0">%s</ul>',
            'active' => '<li class="page-item active disabled"><a class="page-link" href="#">%d</a></li>',
            'disabled' => '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>',
            'link' => '<li class="page-item"><a class="page-link" href="%s">%d</a></li>',
            'prev' => '<li class="page-item previous %s"><a class="page-link" aria-label="Previous" href="%s"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 18 18"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg></a></li>',
            'next' => '<li class="page-item next %s"><a class="page-link" aria-label="Next" href="%s"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 18 18"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg></a></li>',
        ]
    ];

    public function __construct($page, $perpage, $url = 'page')
    {
        $page = $page ? (int)$page : 1;
        if ($page < 1) $page = 1;
        $perpage = (int)$perpage;
        $startpoint = ($page * $perpage) - $perpage;
        $this->instance = array(
            'page'       => $page,
            'limit'      => $perpage,
            'startpoint' => $startpoint,
            'limit_sql'  => "LIMIT {$startpoint}, {$perpage}",
            'url'        => $this->baseUrl($url)
        );
    }

    private function baseUrl($param)
    {
        $url = rtrim($_SERVER['REQUEST_URI'], '/');
        $parsed_url = parse_url($url);
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query = isset($parsed_url['query']) ? $parsed_url['query'] : '';
        parse_str($query, $parameters);
        unset($parameters[$param]);
        $parameters[$param] = '';
        return $path . '?' . http_build_query($parameters);
    }

    public function total($total)
    {
        $this->total = (int)$total;
        return $this;
    }

    public function makeTemplate($name, $template)
    {
        if (is_array($template)) {
            $template = $template + $this->templates['default'];
            $new = array($name => $template);
            $this->templates = array_merge($this->templates, $new);
        }
    }

    public function template($template)
    {
        $this->template = isset($this->templates[$template]) ? $template : 'default';
        return $this;
    }

    public function execute($fullpager = true)
    {
        $currp = $this->instance['page'];
        $total = $this->total;
        $lastp = ceil($total / $this->instance['limit']);
        if ($currp > $lastp) $currp = $lastp;
        $adj   = 3;
        $html = '';
        if ($this->template == 'compact') {
            if ($currp != 1) {
                $html .= sprintf($this->templates[$this->template]['prev'], $this->instance['url'] . ($currp - 1));
            }

            if ($lastp <= 3 + ($adj * 2)) {
                for ($c = 1; $c <= $lastp; $c++) {
                    if ($c == $currp) {
                        $html .= sprintf($this->templates[$this->template]['active'], $c);
                    } else {
                        $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $c, $c);
                    }
                }
            } else {
                if ($currp < (($adj * 2) - 1)) {
                    for ($c = 1; $c <= 5; $c++) {
                        if ($c == $currp) {
                            $html .= sprintf($this->templates[$this->template]['active'], $c);
                        } else {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $c, $c);
                        }
                    }

                    $html .= $this->templates[$this->template]['disabled'];

                    for ($e = $lastp - 4; $e <= $lastp; $e++) {
                        $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $e, $e);
                    }
                } elseif ($lastp - (($adj * 2) - 3) > $currp && $currp > (($adj * 2) - 2)) {
                    for ($f = 1; $f <= 3; $f++) {
                        $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $f, $f);
                    }

                    if ($currp == (($adj * 2) - 1)) {
                        $cstart = $currp;
                    } else {
                        $cstart = $currp - 1;
                    }

                    if ($currp == ($lastp - 4)) {
                        $cend = $currp;
                    } else {
                        $cend = $currp + 1;
                    }

                    if ($cstart == $currp) {
                        $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . ($currp - 1), ($currp - 1));
                    } else {
                        $html .= $this->templates[$this->template]['disabled'];
                    }

                    for ($c = $cstart; $c <= $cend; $c++) {
                        if ($c == $currp) {
                            $html .= sprintf($this->templates[$this->template]['active'], $c);
                        } else {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $c, $c);
                        }
                    }

                    if ($cend == $currp) {
                        $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . ($currp + 1), ($currp + 1));
                    } else {
                        $html .= $this->templates[$this->template]['disabled'];
                    }

                    for ($e = $lastp - 2; $e <= $lastp; $e++) {
                        $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $e, $e);
                    }
                } else {
                    for ($f = 1; $f <= 5; $f++) {
                        $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $f, $f);
                    }

                    $html .= $this->templates[$this->template]['disabled'];

                    for ($c = $lastp - (($adj * 2) - 2); $c <= $lastp; $c++) {
                        if ($c == $currp) {
                            $html .= sprintf($this->templates[$this->template]['active'], $c);
                        } else {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $c, $c);
                        }
                    }
                }
            }

            if ($currp != $lastp) {
                $html .= sprintf($this->templates[$this->template]['next'], $this->instance['url'] . ($currp + 1));
            }

            if ($lastp > 1) {
                return sprintf($this->templates[$this->template]['base'], $html);
            }
        } else {
            if ($currp != 1) {
                $html .= sprintf($this->templates[$this->template]['prev'], null, $this->instance['url'] . ($currp - 1));
            } else {
                $html .= sprintf($this->templates[$this->template]['prev'], 'disabled', '#');
            }
            if ($fullpager) {
                if ($lastp <= 3 + ($adj * 2)) {
                    for ($c = 1; $c <= $lastp; $c++) {
                        if ($c == $currp) {
                            $html .= sprintf($this->templates[$this->template]['active'], $c);
                        } else {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $c, $c);
                        }
                    }
                } else {
                    if ($currp < (($adj * 2) - 1)) {
                        for ($c = 1; $c <= 5; $c++) {
                            if ($c == $currp) {
                                $html .= sprintf($this->templates[$this->template]['active'], $c);
                            } else {
                                $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $c, $c);
                            }
                        }

                        $html .= $this->templates[$this->template]['disabled'];

                        for ($e = $lastp; $e <= $lastp; $e++) {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $e, $e);
                        }
                    } elseif ($lastp - (($adj * 2) - 3) > $currp && $currp > (($adj * 2) - 2)) {
                        for ($f = 1; $f <= 1; $f++) {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $f, $f);
                        }

                        if ($currp == (($adj * 2) - 1)) {
                            $cstart = $currp;
                        } else {
                            $cstart = $currp - 1;
                        }

                        if ($currp == ($lastp - 4)) {
                            $cend = $currp;
                        } else {
                            $cend = $currp + 1;
                        }

                        if ($cstart == $currp) {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . ($currp - 1), ($currp - 1));
                        } else {
                            $html .= $this->templates[$this->template]['disabled'];
                        }

                        for ($c = $cstart; $c <= $cend; $c++) {
                            if ($c == $currp) {
                                $html .= sprintf($this->templates[$this->template]['active'], $c);
                            } else {
                                $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $c, $c);
                            }
                        }

                        if ($cend == $currp) {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . ($currp + 1), ($currp + 1));
                        } else {
                            $html .= $this->templates[$this->template]['disabled'];
                        }

                        for ($e = $lastp; $e <= $lastp; $e++) {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $e, $e);
                        }
                    } else {
                        for ($f = 1; $f <= 1; $f++) {
                            $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $f, $f);
                        }

                        $html .= $this->templates[$this->template]['disabled'];

                        for ($c = $lastp - (($adj * 2) - 2); $c <= $lastp; $c++) {
                            if ($c == $currp) {
                                $html .= sprintf($this->templates[$this->template]['active'], $c);
                            } else {
                                $html .= sprintf($this->templates[$this->template]['link'], $this->instance['url'] . $c, $c);
                            }
                        }
                    }
                }
            }

            if ($currp != $lastp) {
                $html .= sprintf($this->templates[$this->template]['next'], null, $this->instance['url'] . ($currp + 1));
            } else {
                $html .= sprintf($this->templates[$this->template]['next'], 'disabled', '#');
            }

            if ($lastp > 1) {
                return sprintf($this->templates[$this->template]['base'], $html);
            }
        }
    }
}
