

#!/bin/bash

echo "Updating"
sudo rm master.zip
sudo rm index.php
sudo rm README.md
sudo rm update.sh
sudo wget https://github.com/melancholytron/GStreamCam/archive/master.zip
sudo unzip -j master.zip
sudo chmod +x update.sh
echo "UpDooted"
