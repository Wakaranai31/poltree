Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "StopWeb.bat", 0, True
MsgBox "Web Shutdown Berhasil!", 48, "Status Server"