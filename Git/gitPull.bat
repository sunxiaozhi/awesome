CHCP 65001

@ECHO OFF
ECHO "####################################################"
ECHO "# Subject: update git repo                         #"
ECHO "# Date: 2023.04.08                                 #"
ECHO "# Author: sunxiaozhi                               #"
ECHO "####################################################"

ECHO.

SET CURRENT_DIR=%~dp0
ECHO "ROOT DIR: %CURRENT_DIR%"

ECHO.

FOR /f "delims=" %%i IN ('dir /ad/b "%CURRENT_DIR%" ') DO (
    IF EXIST %CURRENT_DIR%\%%i\.git ( 
        ECHO "START update: %CURRENT_DIR%\%%i"
        CD %CURRENT_DIR%\%%i
        git pull
        ECHO "END update: %CURRENT_DIR%\%%i"
		ECHO.
    )
)
CD ..