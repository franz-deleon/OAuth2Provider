#!/bin/bash
# author: franz de leon
# grab the branch and place it in travis composer json

GIT_BRANCH=$(git branch 2>/dev/null| sed -n '/^\*/s/^\* //p')
sed -i "s/%branch%/${GIT_BRANCH}/g" .travis/travis.composer.json