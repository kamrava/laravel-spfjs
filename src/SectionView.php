<?php
namespace Kamrava\Spf;

class SectionView {
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
            'title' => $this->viewExists($this->path.'.sections._title'),
            'head'  => $this->viewExists($this->path.'.sections._head'),
            'body'  => $this->viewExists($this->path.'.sections._body'),
            'foot'  => $this->viewExists($this->path.'.sections._foot'),
        ];
        $output = $this->addSlashesAndRemoveLines($sections);
        $section = json_decode(json_encode($output, JSON_FORCE_OBJECT));
        return view($this->path.'.spf_json', ['section' => $section]);
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

    private function viewExists($viewPath)
    {
        if(view()->exists($viewPath))
            return view($viewPath)->with($this->data)->render();
        return false;
    }
}
