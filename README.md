# approval-staleness-lab

Scratch repo answering one question: which changes to an approved pull request make GitHub throw the approval away?

The motivation was a work repo moving to "require approval of the most recent reviewable push" and heavy use of rebases, squashes and stacked PRs. If every rebase cost a re-review the rule would be unworkable. Nobody could point at documentation precise enough to say, so this repo measures it.

## Setup

- `approve` workflow: approves a given PR as `github-actions[bot]`, so a one-person repo gets a countable second approval. Needs the repo setting that lets Actions approve PRs.
- `botrebase` workflow: rebases a branch onto `main` and force-pushes it, to check that a push from an actor other than the author is treated the same way.
- Dummy files (`app.php`, `*.txt`). `app.php` has a `send_money` function and a test that sets `$money_to_transfer = 9999999;`, which is the "move a line" case: the same line moved from the test into the function is a real behaviour change with an identical diff stat.

Each case is one PR, approved by the bot, then changed in one specific way. The PR title names the rule and the change. Prefixes: `dismiss` (ruleset, dismiss stale approvals), `lastpush` (ruleset, require approval of the most recent reviewable push), `classic` (the same last-push rule under classic branch protection instead of a ruleset), `chain` (branch-chain stack), `stk` and `atm` (GitHub native stacks via `gh stack`).

## Results

Both rules judge what changed in the code, not the commit hash.

| Change after approval | Approval kept? |
|---|---|
| Reword a commit (new hash, same code) | Kept |
| Clean rebase, base changed a different file | Kept |
| Clean rebase, base added lines above the change | Kept |
| Clean rebase, base edited a line next to the change | Kept |
| Squash two commits into one | Kept |
| Move `$money_to_transfer = 9999999;` from the test into `send_money` | Needs re-approval |
| Add new code | Needs re-approval |
| Branch-chain stack: merge the bottom PR, retarget the next PR to `main` | Needs re-approval, and rebasing back to identical code does not restore it |
| Native stack: restack onto an updated `main` | Kept |
| Native stack: change code in a lower PR | PRs above it also need re-approval |
| Native stack: merge the bottom PR with `gh stack merge` | Kept, GitHub rebases the next PR itself |

The same outcomes held under "dismiss stale approvals", under the last-push rule as a ruleset, and under the last-push rule as classic branch protection.

## Takeaways

- The last-push rule can go on in a rebase-heavy repo. Rebases, squashes and rewords cost nothing.
- Moving a line is caught. No custom check needed for the "same diff stat, different behaviour" case.
- Branch-chain stacks lose approvals on retarget. Native stacks keep them, but need `gh stack merge`, since `gh pr merge` on a stacked PR is rejected.

## Not tested

- The "Update branch" button, which merges `main` into the PR instead of rebasing.
- Rulesets' `require_extra_approval_for_unattributed_changes`, which was left at its default (on).
