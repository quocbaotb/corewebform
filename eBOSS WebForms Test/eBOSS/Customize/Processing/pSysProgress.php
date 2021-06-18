<?php
class pSysProgress
{
    private $vTypeProgress;
    private $vCurrentLanguage;
    private $vSqlTable;
    private $vSession;

    public $vDesignerHeader;
    public $vDesignerTitle;
    public $vDesignerFooter;
    public $vTableView;

    public function __construct($CurrentLanguage)
    {
        $this->vSession = new Session();
        $this->vTypeProgress = $this->vSession->GetSession(oWorkManager::_CurrentTypeProgress);
        $this->vCurrentLanguage = $CurrentLanguage;
        $this->vSqlTable = new pSqlTable(false);
    }

    private function GetProductProgress(){
        $this->vTableView = $this->vSqlTable->TableSelect(oSysProgress::coProduceProgress, $this->vCurrentLanguage);
        $this->vDesignerTitle = 'TIẾN ĐỘ SẢN XUẤT';
    }

    private function GetBeforeProgress(){
        $this->vTableView = $this->vSqlTable->TableSelect(oSysProgress::coProduceProgress, $this->vCurrentLanguage);
        $this->vDesignerTitle = 'TIẾN ĐỘ CÔNG TRÌNH TRƯỚC';
    }

    private function GetAfterProgress(){
        $this->vTableView = $this->vSqlTable->TableSelect(oSysProgress::coProduceProgress, $this->vCurrentLanguage);
        $this->vDesignerTitle = 'TIẾN ĐỘ CÔNG TRÌNH SAU';
    }


    private function GetPlasticProgress(){
        $this->vTableView = $this->vSqlTable->TableSelect(oSysProgress::coProduceProgress, $this->vCurrentLanguage);
        $this->vDesignerTitle = 'TIẾN ĐỘ ÉP NHỰA';
    }


    private function GetReceiveProgress(){
        $this->vTableView = $this->vSqlTable->TableSelect(oSysProgress::coProduceProgress, $this->vCurrentLanguage);
        $this->vDesignerTitle = 'TIẾN ĐỘ PHÁT LIỆU';
    }

    private function GetDesinerHeader(){
        $this->vDesignerHeader = "<table class='head'>
                <thead>
                <tr>
                    <th style='width: 3.5vw'>No</th>
                    <th style='width: 9vw'>Machine</th>
                    <th style='width: 14.6vw'>PO#</th>
                    <th style='width: 19.7vw'>Product No</th>
                    <th style='width: 7.8vw'>Quality</th>
                    <th style='width: 7.9vw'>Finish</th>
                    <th style='width: 7.8vw'>UnFinish</th>
                    <th style='width: 12.6vw'>Status</th>
                    <th style='width: 11.9vw'>Handler</th>
                </tr>
                </thead>
            </table>";
    }

    private function GetDesignerFooterProduce(){
        for ($i = 0; $i < count($this->vTableView); $i++) {
            ?>
            <tr class="<?php if ($i % 2 == 0) echo "BackgroundBottom"; else echo "BackgroundTop" ?>" id="<?php echo $i + 1 ?>">
                <td style="text-align: center; width: 3.8vw"><?php echo $i + 1 ?></td>
                <td style="width: 9vw"><?php echo $this->vTableView[$i]['CommandID'] ?></td>
                <td style="width: 15vw"><?php echo $this->vTableView[$i]['CommandID'] ?></td>
                <td style="width: 20vw"><?php echo $this->vTableView[$i]['ProductID'] ?></td>
                <td style="text-align: right; width: 8vw"><?php if ($this->vTableView[$i]['UnFinishProductQty'] <> null) echo number_format($this->vTableView[$i]['UnFinishProductQty']); else echo '-'; ?></td>
                <td style="text-align: right; width: 8vw"><?php if ($this->vTableView[$i]['CommandQty'] <> null) echo number_format($this->vTableView[$i]['CommandQty']); else echo '-'; ?></td>
                <td style="text-align: right; width: 8vw"><?php if ($this->vTableView[$i]['UnFinishProductQty'] <> null) echo number_format($this->vTableView[$i]['UnFinishProductQty']); else echo '-'; ?></td>
                <td style="width: 13vw"><?php echo $this->vTableView[$i]['FinishProcessSID'] ?></td>
                <td style="width: 12vw"><?php echo $this->vTableView[$i]['HandlerName'] ?></td>
            </tr>
            <?php
        }
    }

    public function GetProgress(){
        switch ($this->vTypeProgress){
            case 'T': $this->GetProductProgress(); $this->GetDesinerHeader();
            break;
            case 'U': $this->GetBeforeProgress(); $this->GetDesinerHeader();
            break;
            case 'V': $this->GetAfterProgress(); $this->GetDesinerHeader();
            break;
            case 'W': $this->GetPlasticProgress(); $this->GetDesinerHeader();
            break;
            case 'X': $this->GetReceiveProgress(); $this->GetDesinerHeader();
            break;
        }
    }

    public function GetDesignerFooter(){
        switch ($this->vTypeProgress){
            case 'T': $this->GetDesignerFooterProduce();
                break;
            case 'U': '';
                break;
            case 'V': '';
                break;
            case 'W':'';
                break;
            case 'X': '';
                break;
        }
    }

}