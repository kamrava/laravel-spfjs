<?php
namespace Kamrava\Spf;

class PartialView {
    private $path;
    private $data;

    public function from($path)
    {
        $this->path = $path;
        return $this;
    }

    public function with($data)
    {
        $this->data = $data;
        return $this;
    }

    public function render()
    {
        $sections = [
            'title' => view($this->path.'.partials._title')->with($this->data)->render(),
            'head'  => view($this->path.'.partials._head' )->with($this->data)->render(),
            'body'  => view($this->path.'.partials._body' )->with($this->data)->render(),
            'foot'  => view($this->path.'.partials._foot' )->with($this->data)->render()
        ];
        $output = $this->addSlashesAndRemoveLines($sections);
        $partials = json_decode(json_encode($output, JSON_FORCE_OBJECT));
        return view($this->path.'.spf_json', ['partials' => $partials]);
    }

    private function addSlashesAndRemoveLines($sections)
    {
        if (is_array($sections))
        {
            foreach($sections as $key => $var)
            {
                $result[$key] = addcslashes($var, '"');
                $result[$key] = str_replace(["\r","\n"],"", $result[$key]);
            }
            return $result;
        }
    }
}
