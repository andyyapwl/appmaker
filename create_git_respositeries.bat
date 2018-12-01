cd packages/Webkid/LaravelBooleanSoftdeletes
git init
git add .
git commit -m "first commit"

git remote add origin https://github.com/andyyapwl/appmaker.git
git push -u origin master
git tag -a 1.0.0 -m "release: First version"
git push --tags
