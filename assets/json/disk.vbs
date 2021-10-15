Option Explicit
        const strReport = "C:\Program Files (x86)\Ampps\www\rume\assets\json\resultado.txt"
        const sFile = "C:\Program Files (x86)\Ampps\www\rume\assets\json\equipo.txt"

        Dim objWMIService, objItem, colItems
        Dim strDriveType, strDiskSize, txt

        Dim oFSO, oFile, sText,strComputer
        Set oFSO = CreateObject("Scripting.FileSystemObject")

        Dim objFSO,objTextFile
        Set objFSO = createobject("Scripting.FileSystemObject")
        Set objTextFile = objFSO.CreateTextFile(strReport)

        If oFSO.FileExists(sFile) Then
            Set oFile = oFSO.OpenTextFile(sFile, 1)
            Do While Not oFile.AtEndOfStream
                sText = oFile.ReadLine
                If Trim(sText) <> "" Then
                    strComputer=sText
                        Set objWMIService = GetObject("winmgmts://" & strComputer & "\root\cimv2")
                        Set colItems = objWMIService.ExecQuery("Select * from Win32_LogicalDisk WHERE DriveType=3")

                    For Each objItem in colItems
                        DIM pctFreeSpace,strFreeSpace,strusedSpace
                        pctFreeSpace = INT((objItem.FreeSpace / objItem.Size) * 1000)/10
                        pctFreeSpace = INT(pctFreeSpace)

                        strDiskSize = Int(objItem.Size /1073741824) & "Gb"
                        strFreeSpace = Int(objItem.FreeSpace /1073741824) & "Gb"
                        strUsedSpace = Int((objItem.Size-objItem.FreeSpace)/1073741824) & "Gb"
                        txt = txt &  objItem.Name & "/" & strDiskSize & "/" & strUsedSpace & "/" & strFreeSpace & "/" & pctFreeSpace & vbcrlf
                    Next
                    objTextFile.Write(txt)
                End If
            Loop
            objTextFile.Close
            oFile.Close
        Else
            WScript.Echo "No se encuentra el archivo."
        End If