# Deployment Guide

This file summarizes the steps for publishing the project to GitHub and using GitHub Actions to deploy to shared hosting over FTP.

## 1. Local Git setup
- Make sure Git for Windows is installed and available (Git Bash or PowerShell). The repository is already initialized; to verify run `git status`.
- Commit any pending changes before pushing: `git add . && git commit -m "Your message"`.
- Ensure the remote is set: `git remote add origin https://github.com/<username>/<repo>.git` (already configured as `kayacuneyd/tryna`).
- Push to GitHub whenever you want to deploy: `git push origin main`.

## 2. GitHub Actions workflow
- Workflow file: `.github/workflows/deploy.yml`.
- Triggers: every push to `main` (except changes limited to README, LICENSE, or `.gitignore`) and manual runs via the “Run workflow” button.
- Action used: `SamKirkland/FTP-Deploy-Action@v4.3.5`. It compares a sync-state file (`.ftp-deploy-sync-state.json`) to upload only changed files while leaving existing remote files untouched (`dangerous-clean-slate: false`).

## 3. Required secrets
Add these under **GitHub repo → Settings → Secrets and variables → Actions → New repository secret**:

| Secret name        | Value to enter                                                                 |
|--------------------|-------------------------------------------------------------------------------|
| `FTP_HOST`         | Exact FTP server hostname (e.g., `ftp.yourdomain.com` or the host/IP from cPanel). |
| `FTP_USERNAME`     | FTP account username from hosting panel.                                      |
| `FTP_PASSWORD`     | FTP account password (reset in hosting panel if unknown).                     |
| `FTP_SERVER_DIR`   | Absolute path to the web root or target folder (e.g., `/public_html/`).       |

Tips:
- Use the host value provided in the hosting control panel; copying a wrong domain causes `getaddrinfo ENOTFOUND` errors.
- If DNS for your domain isn’t ready, use the raw server hostname or IP shown under FTP Accounts.
- You can create a dedicated FTP account scoped to the project directory for extra safety.

## 4. Verifying deployments
1. Push to `main` or manually trigger the workflow.
2. Open GitHub → Actions → “Deploy website via FTP” run; confirm it finishes with a green check.
3. If the run fails, open the logs; fix the cause (most common: wrong host, credentials, or directory) and rerun.
4. After a successful run, check your hosting file manager (e.g., `/public_html/`) and load the site in a browser to ensure the new version is live.

## 5. Common issues
- **`getaddrinfo ENOTFOUND ...`**: The `FTP_HOST` secret is wrong or the hostname lacks DNS records. Use the exact value from hosting panel or the server IP.
- **Authentication failures**: Double-check username/password, and verify the FTP account allows access to the target directory.
- **Files not appearing**: Confirm `FTP_SERVER_DIR` points to the correct path; include trailing slash only if hosting requires it (the action handles both).

With the secrets set and the workflow in place, pushing code to `main` automatically publishes the site to your shared hosting.***
