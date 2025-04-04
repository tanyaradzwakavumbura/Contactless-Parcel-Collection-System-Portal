Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "cmd /c notepad /p \"printer_documents/receipt.txt\"", 7, True