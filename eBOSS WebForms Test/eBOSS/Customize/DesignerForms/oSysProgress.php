<?php
class oSysProgress{
    const coProduceProgress = "SELECT        TOP (100) PERCENT CommandMain.CommandID, CommandMain.RecordDate AS CommandDate, CommandMain.ProduceTypeID, ProductInfo.ProductID, ProductInfo.GroupID, ProductInfo.UnitID, CommandProgress.CommandQty, 
                                                         CommandProgress.IsDistribute, CommandProgress.ReceiveQty, CommandProgress.ReturnQty, CommandProgress.FinishProductQty, CommandProgress.UnFinishProductQty, CommandProgress.FinishPercent, 
                                                         FinishProgress.Name AS FinishProcessSID, CommandMain.MaterialDeliveryDate, CommandMain.PreFinishDate, CommandMain.StartDate, CommandProgress.CloseDate, CommandProgress.CommandAID, 
                                                         HandlerInfo.ContractedName AS HandlerName
                                FROM            dbo.tblBasProductInfo AS ProductInfo INNER JOIN
                                                         dbo.GetProduceCommandProgress(NULL, NULL, 1) AS CommandProgress INNER JOIN
                                                         dbo.tblProduceCommandMain AS CommandMain ON CommandProgress.CommandAID = CommandMain.CommandAID ON ProductInfo.ProductAID = CommandProgress.ProductAID INNER JOIN
                                                             (SELECT        '1' AS ID, dbo.fSwitchLang('Language', N'未生產', N'Chưa sản xuất', N'', N'') AS Name
                                                               UNION ALL
                                                               SELECT        '2' AS ID, dbo.fSwitchLang('Language', N'未完成', N'Chưa hoàn thành', N'', N'') AS Name
                                                               UNION ALL
                                                               SELECT        '3' AS ID, dbo.fSwitchLang('Language', N'進行中', N'Đang tiến hành', N'', N'') AS Name
                                                               UNION ALL
                                                               SELECT        '4' AS ID, dbo.fSwitchLang('Language', N'已完成', N'Hoàn thành', N'', N'') AS Name
                                                               UNION ALL
                                                               SELECT        '5' AS ID, dbo.fSwitchLang('Language', N'已結案', N'Đã đóng lệnh', N'', N'') AS Name) AS FinishProgress ON CommandProgress.FinishProcessSID = FinishProgress.ID INNER JOIN
                                                         dbo.tblBasObjectInfo AS HandlerInfo ON CommandMain.HandlerAID = HandlerInfo.ObjectAID
                                ORDER BY CommandDate DESC, CommandMain.CommandID DESC";
}
