﻿using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using RevenueManagement.Models.Entities;
using RevenueManagement.Models.Requests.User;
using RevenueManagement.Services;

namespace RevenueManagement.Controllers
{
    [Authorize]
    public class UserController : Controller
    {
        private readonly UserService userService;
        private readonly RoleService roleService;

        public UserController(UserService userService, RoleService roleService)
        {
            this.userService = userService;
            this.roleService = roleService; 
        }

        public async Task<IActionResult> Index()
        {
            ViewBag.users = await this.userService.GetAll();
            return View();
        }

        [HttpGet]
        public async Task<IActionResult>? Create()
        {
            ViewBag.roles = await this.roleService.GetAllIgnoreSuperAdmin();
            ViewBag.RoleId = User.FindFirst("RoleId").Value;
            return View();
        }

        [HttpPost]
        public async Task<IActionResult> Save(StoreUserRequest request)
        {
            if (ModelState.IsValid)
            {
                if (await this.userService.Save(request))
                {
                    ViewBag.Status = "success";
                    ViewBag.Message = "Cập nhật tài khoản thành công!";
                } else
                {
                    ViewBag.Status = "failed";
                    ViewBag.Message = "Cập nhật tài khoản thất bại!";
                }

                return View();
            }

            return View(request);
        }

        [HttpGet]
        public IActionResult? Edit()
        {
            return null;
        }

        [HttpPatch]
        public IActionResult? Update()
        {
            return null;
        }

        [HttpDelete]
        public IActionResult? Delete()
        {
            return null;
        }

        [HttpGet]
        public IActionResult? ChangePassword()
        {
            return View();
        }

        [HttpPost, ValidateAntiForgeryToken]
        public async Task<IActionResult> ChangePassword(ChangePasswordRequest request)
        {
            if (ModelState.IsValid)
            {
                long userId = Convert.ToInt64(User.FindFirst("Id").Value);

                var user = await this.userService.GetById(userId);

                if (user is null)
                {
                    return RedirectToAction("Login", "Auth");
                }

                if (!this.userService.CheckPassword(user, request.CurrentPassword))
                {
                    ViewBag.ErrorCurrentPassword = "Mật khẩu cũ không chính xác!";
                    return View();
                }

                if (await this.userService.ChangePassword(user, request.NewPassword))
                {
                    ViewBag.Status = "success";
                    ViewBag.Message = "Cập nhật mật khẩu thành công!";
                }
                else
                {
                    ViewBag.Status = "failed";
                    ViewBag.Message = "Cập nhật mật khẩu thất bại!";
                }

                return View();
            }

            return View(request);
        }

        [HttpGet]
        public async Task<IActionResult> Information()
        {
            var userId = Convert.ToInt64(User.FindFirst("Id").Value);

            var user = await this.userService.GetById(userId);

            if (user is null)
            {
                return RedirectToAction("Login", "Auth");
            }

            user.Password = null;

            return View(user);
        }

        [HttpPost, ValidateAntiForgeryToken]
        public async Task<IActionResult> Information(InformationRequest request)
        {
           
            var userId = Convert.ToInt64(request.Id);

            var user = await this.userService.GetById(userId);

            if (user is not null)
            {
                user.Name = request.Name;
                user.Phone  = request.Phone;
                user.Email = request.Email;
                user.Phone = request.Phone;
                user.Sex = request.Sex; 
                user.Image = request.Image;
                
                if (await this.userService.UpdateInformation(user))
                {
                    ViewBag.Status = "success";
                    ViewBag.Message = "Cập nhật tài khoản thành công!";
                } else
                {
                    ViewBag.Status = "failed";
                    ViewBag.Message = "Cập nhật tài khoản thất bại!";
                }

                return View(user);
            }


            return RedirectToAction("Login", "Auth");
        }
    }
}
