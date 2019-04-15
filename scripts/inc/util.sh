#!/usr/bin/env bash

# Colors.
util::echo() {
    case "$1" in
        # Alert: action must be taken immediately.
        alert*)     echo "$(tput setaf 1)${2}$(tput sgr0)";;
        # Critical conditions.
        critical*)  echo "$(tput setaf 2)${2}$(tput sgr0)";;
        # Error conditions.
        error*)     echo "$(tput setaf 3)${2}$(tput sgr0)";;
        # Warning conditions.
        warning*)   echo "$(tput setaf 4)${2}$(tput sgr0)";;
        # Normal but significant conditions.
        notice*)    echo "$(tput setaf 5)${2}$(tput sgr0)";;
        # Informational messages.
        info*)      echo "$(tput setaf 6)${2}$(tput sgr0)";;
        # Debug-level messages.
        debug*)     echo "$(tput setaf 7)${2}$(tput sgr0)";;
    esac
}

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
    read -rp "$(util::echo alert "$1: ")" val
    echo "$val"
}
