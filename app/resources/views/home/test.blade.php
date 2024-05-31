

      //Projects page
    public function projects(Request $req)
    {
        $ProjectsCount = count($this->getProjects());
        $formData = array("Settings" => $this->Settings, "CompanySettings" => $this->CompanySettings, "PageTitle" => "Projects", "ProjectsCount" => $ProjectsCount, "FooterAboutUs" => $this->getFooterAboutUs());
        return view('home.projects', $formData);
    }
    //Project Details Page
    public function projectDetails(Request $req, $Slug)
    {
        $Project = $this->getProjects(array('where' => array("Slug" => $Slug)));
        if (count($Project) > 0) {
            $Project = $Project[0];
            $formData = array("Settings" => $this->Settings, "CompanySettings" => $this->CompanySettings, "PageTitle" => "Project Details", "Project" => $Project, "FooterAboutUs" => $this->getFooterAboutUs());
            $formData['RelatedProjects'] = $this->getProjects(array("OrderBy" => "Order By RAND()", "limit" => " limit 8"));
            return view('home.project-details', $formData);
        } else {
            return view('errors.404');
        }
    }
    public function getProjectsList(Request $req)
    {
        $currentPage = $req->currentPage;
        $limitPerPage = $req->limitPerPage;
        $from = (($currentPage - 1) * $limitPerPage);
        $limit = " limit " . $from . "," . $limitPerPage . ";";
        $OrderBy = "Order By P.ProjectID asc";
        if ($req->sortby == "ProjectName-Asc") {
            $OrderBy = "Order By P.ProjectName asc";
        } elseif ($req->sortby == "ProjectName-Desc") {
            $OrderBy = "Order By P.ProjectName desc";
        } 
        $formData = array("Settings" => $this->Settings, "CompanySettings" => $this->CompanySettings);
        $formData['Projects'] = $this->getProjects(array("limit" => $limit, "OrderBy" => $OrderBy));
        return view('home.projects-list', $formData);
    }


     private function getProjects($data = array())
    {
        $sql = " Select P.ProjectID, P.ProjectName, P.ProjectImage, P.ProjectType as PID, P.PName as ProjectTypeName, P.Address, P.Description ";
        $sql .= " From tbl_projects as P  LEFT JOIN tbl_project_type as C ON C.PID=P.ProjectType";
      
        $sql .= " Where P.ActiveStatus=1 and P.DFlag=0 ";
        if (is_array($data)) {
            if (array_key_exists("where", $data)) {
                if (array_key_exists("ProjectID", $data['where'])) {$sql .= " and P.ProjectID='" . $data['where']['ProjectID'] . "'";}
                if (array_key_exists("Slug", $data['where'])) {$sql .= " and P.Slug='" . $data['where']['Slug'] . "' ";}
                if (array_key_exists("ProjectType", $data['where'])) {$sql .= " and P.ProjectType='" . $data['where']['ProjectType'] . "' ";}

            }
            if (array_key_exists("OrderBy", $data)) {
                $sql .= " " . $data['OrderBy'];
            } else {
                $sql .= " Order By P.ProjectName  asc";
            }
            if (array_key_exists("limit", $data)) {
                $sql .= " " . $data['limit'];
            }
        }
        $result = DB::SELECT($sql);
        for ($i = 0; $i < count($result); $i++) {
            $result[$i]->galleryImages = DB::Table('tbl_projects_gallery')->where('ProjectID', $result[$i]->ProjectID)->get();
        }
        return $result;
    }

