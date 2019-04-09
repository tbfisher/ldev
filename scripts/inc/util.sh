#!/usr/bin/env bash

# No realpath on mac.
util::realpath() {
    unameOut="$(uname -s)"
    case "${unameOut}" in
        Darwin*)    grealpath "$@";;
        *)          realpath "$@";;
    esac
}

# Takes path, pattern, gets size of most recent match, or 0 of none found.
util::filesize() {
    local dumpfile
    dumpfile=$(find "$1" -maxdepth 1 -name "$2" | sort -r | head -n 1)
    if [[ -z "$dumpfile" ]]; then
        echo 0
        return
    fi
    case "$(uname -s)" in
        Darwin*)    stat -f %z "$dumpfile";;
        *)          stat -c %s "$dumpfile"
    esac
}

# Print argument to stdout and read response.
util::prompt() {
    read -rp "$1"": " val
    echo "$val"
}
